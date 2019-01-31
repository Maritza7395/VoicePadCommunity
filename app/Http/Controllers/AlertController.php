<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\Complaint;
use App\Mail\NewComplaint;
use Illuminate\Support\Facades\Mail;

class AlertController extends Controller
{
	public function index_user($user_id){
		$user = \App\User::findOrFail($user_id); 
		$alerts = $user->alerts->toArray();
		$arrayAlerts = [];
		foreach ($alerts as $alert) {
			$created_at = Carbon::parse($alert['pivot']['created_at'])->format('d/m/Y');
			$alert['pivot']['created_at'] =  $created_at;
			$arrayAlerts [] = $alert;
		}
		return $arrayAlerts;

	}
    public function store(Request $request)
    {
        $user_id = $request->get('user_id');
        $user_admin = Auth::user();
        $user = \App\User::findOrFail($user_id); 
       	//restriccion de envio de alerta uno por dia
       	$alerts = $user->alerts()->whereDate('alerts.created_at','=',Carbon::today())->get()->toArray();
       	if (count($alerts) == 0){
       			$user->alerts()->attach($user_admin->id);
       			$alerts = $user->alerts->toArray();
       			$this->notification($user,$alerts);
       			$this->sendMail($user,$alerts);
       	 // $complaint= $user->complaint_user()->where('user_complaint_id','=', $idUserComplaint)->get();
       		return 'ok';   
       	}   
       	return 'failed';  
    }
    public function notification ($user,$alerts){
    	$route=$user->existPicturePerfil($user->name_user,$user->sex);   
    	$notification=[
            'user_id'=> $user->id,
            'name_user_id'=> $user->name_user,
            'message'=> 'Advertencia número '.count($alerts).' : Usted podria ser bloqueado si sigue acumulando denuncias',
            'routePictureUser'=> $route, 
            'link' => '/notificaciones',
        ]; 
        $user->notify(new Complaint($notification)); 
    }
    public function sendMail($user, $alerts){
    	$data = [
                'name' => $user->name_user,
                'message' => 'Advertencia número <b>'.count($alerts).'<b> : Usted podria ser <b>BLOQUEADO<b> del sitio si sigue acumulando mas denuncias.',
            ];
        Mail::to($user->email)->send(new NewComplaint($data)); 
    }
}
