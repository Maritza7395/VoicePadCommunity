<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\NewComplaint;
use Illuminate\Support\Facades\Mail;
use App\Notifications\Complaint;
use App\Notifications\AdministrativeNotification;
use App\Http\Requests\CreateComplaintSummernoteRequest;
use App\User;

class ComplaintSummernotesController extends Controller
{
    public function index(){
    	return view('summernote.complaint');
    }
    public function indexData(Request $request){
        $limit = $request->get('limit');
        $order = $request->get('order');
        $dateStart= $request->get('dateStart');
        $dateEnd= $request->get('dateEnd');
        if($order == "all"){
            $order = "desc";
        }
        if($limit != 0){
            $contador = $this->contador($limit, $order,$dateStart, $dateEnd);
            $limit = $limit+$contador;
        }
         $data = \App\Summernote::complaints($limit, $order,$dateStart, $dateEnd); 
         $start = \App\ComplaintText::orderBy('created_at','asc')->first();
         $arraySummernotes = [];
         if($start){
            $arraySummernotes=[
            'dateStart'=> $start->created_at
             ];
             if($data){
                foreach ($data as $value) {
                   $summernote = \App\Summernote::find($value->summernote_id);
                   if($summernote){
                        $summernote['motivations_count'] = $value->countComplaints;
                        $summernote->genre;
                        $arraySummernotes ['summernotes'][] = $summernote;
                   }              
                }
             }
         }
         
         return response()->json($arraySummernotes);
    }    
     public function contador ($limit, $order,$dateStart, $dateEnd){ //si hay usuarios bloqueados
        $cont = 0;
        $data = \App\Summernote::complaints($limit, $order,$dateStart, $dateEnd);
        if($data){
            foreach ($data as $value) {
               $summernote = \App\Summernote::find($value->summernote_id);
               if(count($summernote) == 0 ){
                    $cont ++;     
               }            
            }
        }
        return $cont;
    } 
    public function showData($id){       
        $summernote = \App\Summernote::findOrFail($id);
        $user = \App\User::findOrFail($summernote->user_id);
        $this->authorize('different',$user);
        $users = $summernote->complaint_summernote->toArray();
        $arrayUsers = [];
        foreach ($users as $us) {
           $date = Carbon::parse($us['pivot']['created_at'])->format('d/m/Y');
           $us['pivot']['created_at'] = $date;
           $date = Carbon::parse($us['pivot']['updated_at'])->format('d/m/Y');
           $us['pivot']['updated_at'] = $date;
           $arrayUsers [] = $us;
        }
        return response()->json($arrayUsers);
    }
    public function show($idSummernote){
    	$summernote = \App\Summernote::findOrFail($idSummernote);
        $user = \App\User::findOrFail($summernote->user_id);
        $this->authorize('different',$user);
    	return view('summernote.detailsComplaint',compact('summernote'));
    }
    public function store (CreateComplaintSummernoteRequest $request){
    	$user=Auth::user();
        $idSummernoteComplaint=$request->get('idSummernoteComplaint');
        $idMotivation=$request->get('idMotivation');
        $description = $request->get('description');
        $summernote=\App\Summernote::findOrFail($idSummernoteComplaint);
        $userD = \App\User::findOrFail($summernote->user_id);
        $this->authorize('different',$userD);
        $complaints=\App\Summernote::findOrFail($idSummernoteComplaint)->complaint_summernote()->where('user_id',$user->id)->get();
        if($complaints){
            foreach ($complaints as $complaint) {
                if($complaint->pivot->motivation_text_id == $idMotivation){
                    return 'failed';
                }
            }
        }        
        $user->complaint_summernote()->attach($idSummernoteComplaint, ['motivation_text_id' => $idMotivation , 'description' => $description]);  
        
        $User=\App\Summernote::findOrFail($idSummernoteComplaint)->complaint_summernote()->where('user_id',$user->id)->get();
       
        if($summernote->existPictureSummernote($idSummernoteComplaint)){
            $route=asset('storage/coverText/'.$idSummernoteComplaint);
        }else{
            $route=asset('storage/coverText/default');
        }  
        $notification=[
            'user_id'=> $user->id,
            'name_user_id'=> $user->name_user,
            'message'=> 'Se ha efectuado una denuncia a un Libro',
            'routePictureUser'=> $route, 
            'link' => '/complaintSummernotes/'.$idSummernoteComplaint,
        ]; 
        $admins = \App\User::where('role_id','=', 1)->where('id','!=',$user->id)->get(); //no llegar not a adm que eectua denuncia
        foreach ($admins as $admin) {
            if($admin->id != $summernote->user_id){ //no llegar not a administrador dueño del libro denunciado
                 $admin->notify(new AdministrativeNotification($notification) ); 
            }
        }  
        return response()->json($User);
    }
    public function isComplaintAuth ($idSummernote){//verifica si el usuario autenticado denuncio el libro
        $user=Auth::user();
        $User=\App\Summernote::findOrFail($idSummernote)->complaint_summernote()->where('user_id',$user->id)->get();
        return response()->json($User);
    }
    public function denied(Request $request){ //deniega las denuncias
        $complaint_id = $request->get('complaint_id');
        $complaint = \App\ComplaintText::findOrFail($complaint_id);
        if($complaint->status == 'I'){
            $complaint->status = 'F';
            $complaint->denied = 1;
            $complaint->save();
            return 'ok';
        }
        return 'failed'; 
    }
    public function acceptPlagiarism(Request $request){
        $complaint_id = $request->get('complaint_id');
        $complaint = \App\ComplaintText::findOrFail($complaint_id);
        if(($complaint->status == 'I') && ($complaint->motivation_text_id == 1)){ //verificando que el motivo de denuncia es el correcto
            $complaint->status = 'F';
            $complaint->denied = 0;
            $complaint->save();
            $summernote = \App\Summernote::findOrFail($complaint->summernote_id);
            $summernote->private = 1;
            $summernote->save();
            $user = \App\User::findOrFail($summernote->user_id);
            //mail a autor del libro 
            $this->sendMail($user,$summernote,$complaint);
            //notificacion
            $route=$user->existPicturePerfil($user->name_user,$user->sex);    
            $notification = [
                'user_id'=> $user->id,
                'name_user_id'=> $user->name_user,
                'message'=> 'Tu Libro '.$summernote->name.' ha sido denunciado por plagio, nunca mas podra volver a ser publico',
                'routePictureUser'=> $route, 
                'link' => '/summernote/'.$complaint->summernote_id.'/edit',
            ]; 
            $user->notify(new Complaint($notification));

            return 'ok';
        }
        return 'failed';
    }
    public function sendMail($user,$summernote,$complaint){
        $data = [
                'name' => $user->name_user,
                'message' => 'Su libro "'.$summernote->name.'" ha sido Denunciado por <b>PLAGIO</b>, Por lo tanto este <b>NO</b> podra volver a ser <b>PUBLICO</b> nunca mas, Aqui la descripcion de la denuncia que ha sido aceptada : "'.$complaint->description.'"',
            ];
        Mail::to($user->email)->send(new NewComplaint($data)); 
    }
     public function acceptGenre(Request $request){ 
        $complaint_id = $request->get('complaint_id');
        $complaint = \App\ComplaintText::findOrFail($complaint_id);
        if(($complaint->status == 'I') && ($complaint->motivation_text_id == 2)){
            $complaint->status = 'P';
            $complaint->denied = 0;
            $complaint->save();
            $summernote = \App\Summernote::findOrFail($complaint->summernote_id);
            $summernote->private = 1;
            $summernote->save();
            $summernote->genre;
            $user = \App\User::findOrFail($summernote->user_id);
            $array_description =  explode(" ", $complaint->description);
            $genre_name = $array_description[3];
            $genres = \App\Genre::all();
            $genre = [];
            foreach ($genres as $gen) {
               if($gen->name == $genre_name){
                    $genre = $gen;
               }
            }
            //enviar mail
            $data = [
                    'name' => $user->name_user,
                    'message' => 'Su libro <b>"'.$summernote->name.'"</b> ha sido Denunciado por <b>GENERO EQUIVOCADO</b>, Por lo tanto este, <b>NO</b> podra volver a ser <b>PUBLICO</b> hasta que cambie el <b>Genero "'.$summernote->genre->name.'" por "'.$genre_name.'"</b>',
            ];
            Mail::to($user->email)->send(new NewComplaint($data)); 
             //notificacion
            $route=$user->existPicturePerfil($user->name_user,$user->sex);    
            $notification = [
                'user_id'=> $user->id,
                'name_user_id'=> $user->name_user,
                'message'=> 'Tu Libro "'.$summernote->name.'" ha sido denunciado por Genero Incorrecto, cambielo a "'.$genre_name.'" para que pueda volver a ser publicado',
                'routePictureUser'=> $route, 
                'link' => '/summernote/'.$complaint->summernote_id.'/edit',
            ]; 
            $user->notify(new Complaint($notification));

            return 'ok';
        }
        return 'failed';
    }
     public function acceptAdult(Request $request){
        $complaint_id = $request->get('complaint_id');
        $complaint = \App\ComplaintText::findOrFail($complaint_id);
        if(($complaint->status == 'I') && ($complaint->motivation_text_id == 3)){
            $complaint->status = 'P';
            $complaint->denied = 0;
            $complaint->save();
            $summernote = \App\Summernote::findOrFail($complaint->summernote_id);
            $summernote->private = 1;
            $summernote->save();
            $user = \App\User::findOrFail($summernote->user_id);
            //mail a autor del libro 
            $data = [
                    'name' => $user->name_user,
                    'message' => 'Su libro <b>"'.$summernote->name.'"</b> ha sido Denunciado por <b>Tener contenido para adultos</b>, <b>CLASIFIQUELO CORRECTAMENTE</b>, Por lo tanto este <b>NO</b> podra volver a ser <b>PUBLICO</b> hasta que haga el cambio correspondiente',
            ];
            Mail::to($user->email)->send(new NewComplaint($data)); 
            //notificacion
            $route=$user->existPicturePerfil($user->name_user,$user->sex);    
            $notification = [
                'user_id'=> $user->id,
                'name_user_id'=> $user->name_user,
                'message'=> 'Tu Libro '.$summernote->name.' ha sido denunciado por ser para +18, Clasifiquelo como tal para que pueda volver a ser publicado',
                'routePictureUser'=> $route, 
                'link' => '/summernote/'.$complaint->summernote_id.'/edit',
            ]; 
            $user->notify(new Complaint($notification));

            return 'ok';
        }
        return 'failed';
    }

}
