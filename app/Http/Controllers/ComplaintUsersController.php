<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Complaint;
use App\Mail\NewComplaint;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Notifications\AdministrativeNotification;

class ComplaintUsersController extends Controller
{
    public function index(){//protegida
    	return view('users.complaint');
    }
    public function indexData(Request $request){//protegida
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
        $data = \App\User::complaints($limit, $order,$dateStart, $dateEnd);
         $start = \App\ComplaintUser::orderBy('created_at','asc')->first();
         $created_at = explode('/',$start->created_at);
         $users=[
            'dateStart'=> $created_at[2].'-'.$created_at[1].'-'.$created_at[0]
         ];
        if($data){
            foreach ($data as $value) {
               $user = \App\User::find($value->idUser);
               if($user){
                   $user['motivations_count'] = $value->countComplaints;
                   $users ['users'][] = $user;
               }             
            }
        }         
         return response()->json($users);
    }
    public function contador ($limit, $order,$dateStart, $dateEnd){ //si hay usuarios bloqueados
        $cont = 0;
        $data = \App\User::complaints($limit, $order,$dateStart, $dateEnd);
        $users = [];
        if($data){
            foreach ($data as $value) {
               $user = \App\User::find($value->idUser);
               if(count($user) == 0 ){
                    $cont ++;     
               }            
            }
        }
        // $this->users($limit, $order,$dateStart, $dateEnd, $cont);
        return $cont;
    }

    public function show($id){//protegida
    	$user = \App\User::findOrFail($id);
        $this->authorize('different',$user);
    	return view('users.detailsComplaint',compact('user'));
    }
     public function showData($id){//protegida
        $user = \App\User::find($id);
        $this->authorize('different',$user);
        $users = $user->user_complaint->sortByDesc('pivot.created_at')->toArray();
        $arrayUsers = [];
        foreach ($users as $us) {
           $date = Carbon::parse($us['pivot']['created_at'])->format('d/m/Y');
           $us['pivot']['created_at'] = $date;
           $arrayUsers [] = $us;
        }
        return response()->json($arrayUsers);
    }
    public function store(Request $request){     //protegida   
        $idUserComplaint=$request->get('idUserComplaint');
        $idMotivation=$request->get('idMotivation');
        $userComplaint = \App\User::findOrFail($idUserComplaint);
        $this->authorize('different',$userComplaint); // no denunciarse a si mismo
    	$user=Auth::user();
        $complaint= $user->complaint_user()->where('user_complaint_id','=', $idUserComplaint)->get();
        //Proteccion de duplicacion de denuncia
        if(count($complaint) != 0){ 
            return response()->json('');
        }        
        $user->complaint_user()->attach($idUserComplaint, ['motivation_user_id' => $idMotivation]);   
        //Generacion de notificacion a Admin 
        $route=$user->existPicturePerfil($userComplaint->name_user,$userComplaint->sex);      
        $notification=[
            'user_id'=> $userComplaint->id,
            'name_user_id'=> $userComplaint->name_user,
            'user_complaint_id'=> $userComplaint->id,
            'message'=> 'Se ha efectuado una denuncia a un Usuario',
            'routePictureUser'=> $route, 
            'link' => '/complaintUsers/'.$userComplaint->id,
        ]; 
        $admins = \App\User::where('role_id','=', 1)->where('id','!=',$user->id)->get(); //no llegar not a adm que eectua denuncia
        foreach ($admins as $admin) {
            if($admin->id != $userComplaint->id){//no llegar not a administrado denunciado
                 $admin->notify(new AdministrativeNotification($notification) ); 
            }
        }     
        //Generacion de notificacion a Usuario denunciado
         $notification=[
            'user_id'=> $userComplaint->id,
            'name_user_id'=> $userComplaint->name_user,
            'user_complaint_id'=> $userComplaint->id,
            'message'=> 'Se ha efectuado una denuncia en tu contra',
            'routePictureUser'=> $route, 
            'link' => '/notificaciones',
        ]; 
        $userComplaint->notify(new Complaint($notification) ); 
        //Generacion de Correo a Usuario denunciado
        $motivation = \App\MotivationUser::findOrFail($idMotivation);
        $data = [
                'name' => $userComplaint->name_user,
                'message' => 'Has recibido una nueva Denuncia por : <b>'.$motivation->name.'</b>',
            ];
        Mail::to($userComplaint->email)->send(new NewComplaint($data));    

        return response()->json($idMotivation);
    }
    public function isComplaintAuth ($idUserProfile){//verifica si el usuario autenticado denuncio el libro
        $user=Auth::user();
        $Motivation=\App\User::find($user->id)->complaint()->where('user_id',$user->id)->where('user_complaint_id',$idUserProfile)->get();
        return response()->json($Motivation);
    }
}
