<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\FollowUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class FollowsController extends Controller
{
    public function contador ($limit, $order){ //si hay usuarios bloqueados
        $cont = 0;
         $data = \App\User::follows($limit, $order);;
        $users = [];
        if($data){
            foreach ($data as $value) {
               $user = \App\User::find($value->idUser);
               if(count($user) == 0 ){
                    $cont ++;     
               }            
            }
        }
        return $cont;
    }
    public function index(Request $request){
        $limit = $request->get('limit');
        $order = $request->get('order');
        if($order == "all"){
            $order = "desc";
        }
        if($limit != 0){
            $contador = $this->contador($limit, $order);
            $limit = $limit+$contador;
        }
         $data = \App\User::follows($limit, $order);
         $users=[];
         if($data){
            foreach ($data as $value) {
               $user = \App\User::find($value->idUser);
               if($user){
                    $user['followCount'] = $value->countUser;
                    $users [] = $user;
               }               
            }
         }
         return response()->json($users);       
    }
    public function indexFollowers($idUser){ //devuelve array de rutas de seguidores que tiene el usuario
    	$arrayUsers=[];
        $users=\App\User::find($idUser)->followers;
        foreach ($users as $user ) {            
            $user['route']=$user->existPicturePerfil($user->name_user,$user->sex);
            array_push($arrayUsers, $user);
        }   
        return response()->json($arrayUsers);

    }
    public function indexFollowed($idUser){ //devuelve array de rutas de seguidos que tiene el usuario
    	$arrayUsers=[];
        $users=\App\User::findOrFail($idUser)->followed;
        foreach ($users as $user ) {
            $nameUser=$user['name_user'];   
            $sex=$user['sex'];
            $user['route']=$user->existPicturePerfil($nameUser,$sex);
            array_push($arrayUsers, $user);
        }   
        return response()->json($arrayUsers);

    }
    public function store(Request $request){
        $user = Auth::user();
        $idUserFollow=$request->get('idUserFollow');
        $UserFollow=\App\User::findOrFail($idUserFollow);
        $this->authorize('different',$UserFollow);
        //verificacion de duplicacion
        $followed = $user->followed()->where('user_follow_id',$idUserFollow)->get();
        if(count($followed) != 0){ // si lo sigue
             return response()->json('failed');
        }  
        $route=$user->existPicturePerfil($user->name_user,$user->sex);        
        $user->followed()->attach($idUserFollow);
        $notificationUser=[
            'user_id'=> $user->id,
            'name_user_id'=> $user->name_user,
            'user_follow_id'=> $idUserFollow,
            'message'=> $user->name_user.' comenzó a seguirte',
            'routePictureUser'=> $route, 
            'link' => '/usuarios/'.$user->id,
        ];

        $UserFollow->notify(new FollowUser($notificationUser) );
        return response()->json('ok');//no lo sigue
    }
    public function destroy(Request $request){
    	$user = Auth::user();
        $idUserFollow=$request->get('idUserFollow');
        $followed = $user->followed()->where('user_follow_id',$idUserFollow)->get();
        if(count($user) != 0){ // si lo sigue
            $user->followed()->detach($idUserFollow);   
             return response()->json('ok');
        }               
        return response()->json('false');
    }
    public function isFollow($idUserProfile){//Verifica si el usuario sigue al usuario del perfil
        $user=Auth::user();
        $followed=\App\User::findOrFail($user->id)->followed()->where('user_follow_id',$idUserProfile)->get();
        if(count($followed) != 0){
             return response()->json('1');//si es seguido
        }
        return response()->json('0');//si no lo sigue
    }
}
