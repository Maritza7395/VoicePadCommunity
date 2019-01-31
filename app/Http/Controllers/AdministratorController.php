<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewAdministratorN;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewAdministrator;
use App\Notifications\AdministrativeNotification;
use App\Http\Requests\CreateAdministratorRequest;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller
{
    public function index()
    {
         return view('users.administrators.index');
    }
    public function indexData(){
    	 $administrators=\App\Administrator::all();
    	 return response()->json($administrators);
    }
    public function store(CreateAdministratorRequest $request){
        $user=\App\User::where('email',$request->get('email'))->first();
        if(count($user)){
        	//convertir un escritor a administrador
        	$user->role_id = 1;
        	$user->save();
            //notificar que ha sido cambiado a rol administrador
            $notificationUser=[
                'user_id'=> $user->id,
                'name_user_id'=> $user->name_user,
                // 'user_comment_id'=> $summernote->user_id,
                'message'=> "Felicidades ahora te has convertido en Administrador ",
                'routePictureUser'=> $user->existPicturePerfil($user->name_user,$user->sex), 
                'link' => '/',
            ];
            $userNotification=\App\User::find($user->id);
            $userNotification->notify(new AdministrativeNotification($notificationUser) );

        	//crear registro de administrador
        	$administrator= new \App\Administrator();
        	$administrator->email= $request->get('email');
	    	$administrator->registered= 1;
	    	$administrator->save();
	    	//enviar correo electronico
	    	$data = [
	    		'message' => 'Tu rol de escritor ha cambiado a ADMINISTRADOR, Visitanos en el siguiente enlace',
	    		'url' => '/login'
	    	];
            Mail::to($request->get('email'))->send(new NewAdministratorN($data));
        }
        else{
        	//crear registro de administrador
        	$administrator= new \App\Administrator();
        	$administrator->email= $request->get('email');
	    	$administrator->registered= 0;
	    	$administrator->save();
	    	//enviar correo electronico
	    	$data = [
	    		'message' => 'Has sido invitado a ser parte de nuestra comunidad como ADMINISTRADOR , Para hacer valida esta invitacion, debes registrarte con este email en el siguiente enlace',
	    		'url' => '/register'
	    	];
        	Mail::to($request->get('email'))->send(new NewAdministratorN($data));
        }
    	return response()->json($request->get('email'));
    }
    public function destroy($id)
    {
        $administrator=\App\Administrator::findOrFail($id);
        $userAuth = Auth::user();
        if($userAuth->email == $administrator->email){
            return 'failed';
        }
        $user=\App\User::where('email',$administrator->email)->first();
        if($user){
        	$user->role_id = 2;
	        $user->save();
	        $notificationUser=[
	            'user_id'=> $user->id,
	            'name_user_id'=> $user->name_user,
	            // 'user_comment_id'=> $summernote->user_id,
	            'message'=> "Tu rol de Administrador ha sido revocado ",
	            'routePictureUser'=> $user->existPicturePerfil($user->name_user,$user->sex), 
	            'link' => '/',
	        ];
	        $userNotification=\App\User::find($user->id);
	        $userNotification->notify(new NewAdministrator($notificationUser) );  
	        $administrator->delete();
        }
	else{
		$administrator->delete();
	}
        
        return "ok";
    }
    public function update(Request $request, $id)
    {
        $messages = [
             'email.email' => 'correo electrónico no válido',
        ];
         $validatedData = $request->validate([
         'email'=>'required|max:255|email|string|unique:administrators,email,'.$id
        ],$messages);
         $administrator=\App\Administrator::findOrFail($id);
         $userAuth = Auth::user();
        if($userAuth->email == $administrator->email){ // no se puede editar asi mismo
            return 'failed';
        }
         if($administrator){
         	//revirtiendo registro anterior
         	$user=\App\User::where('email',$administrator->email)->first();
         	if($user){
         		$user->role_id=2;
         		$user->save();
         	}
         	$user=\App\User::where('email',$request->get('email'))->first();
	        if(count($user)){
	        	//convertir un escritor a administrador
	        	$user->role_id = 1;
	        	$user->save();
                //notificar que ha sido cambiado a rol administrador
                $notificationUser=[
                    'user_id'=> $user->id,
                    'name_user_id'=> $user->name_user,
                    // 'user_comment_id'=> $summernote->user_id,
                    'message'=> "Felicidades, ahora te has convertido en Administrador ",
                    'routePictureUser'=> $user->existPicturePerfil($user->name_user,$user->sex), 
                    'link' => '/',
                ];
                $userNotification=\App\User::find($user->id);
                $userNotification->notify(new AdministrativeNotification($notificationUser) );                
                

	        	//edita registro de administrador
	        	$administrator->email= $request->get('email');
		    	$administrator->registered= 1;
		    	$administrator->save();
		    	//enviar correo electronico
		    	$data = [
		    		'message' => 'Tu rol de escritor ha cambiado a Administrador, Visitanos en el siguiente enlace',
		    		'url' => 'login'
		    	];
	        }
	        else{
	        	//edita registro de administrador
	        	$administrator->email= $request->get('email');
		    	$administrator->registered= 0;
		    	$administrator->save();
		    	//enviar correo electronico
		    	$data = [
		    		'message' => 'Has sido invitado a ser parte de nuestra comunidad como administrador , Para hacer valida esta invitacion, debes registrarte con este email en el siguiente enlace',
		    		'url' => '/register'
		    	];
	        	Mail::to($request->get('email'))->send(new NewAdministratorN($data));
	        }

         }
        return response()->json($request->get('email'));
    }

    public function sendEmail(Request $request){
        $administrator=\App\Administrator::all()->where('email','=',$request->get('email'))->where('registered','!=',1)->first();
        if($administrator){
            $userAuth = Auth::user();
            if($userAuth->email == $administrator->email){ // no se puede editar asi mismo
                return 'failed';
            }
            $data = [
                'message' => 'Has sido invitado a ser parte de nuestra comunidad como administrador , Para hacer valida esta invitacion, debes registrarte con este email en el siguiente enlace',
                'url' => '/register'
            ];
            $email = $request->get('email');
            Mail::to($email)->send(new NewAdministratorN($data));
            return response()->json($request->get('email'));
        }
        else{
            return 'failed';
        }
       
        
    }
}
