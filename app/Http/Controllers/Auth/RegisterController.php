<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Mail\ConfirmedEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\send_mail_verify;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    

    protected $redirectTo = '/';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('checkRoleRegister');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       
        $user = new User($data);
        return Validator::make($data, [
            'name_user' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'birthdate' => 'required|date|max:255|before:13 years ago | after:100 years ago',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'image|mimes:jpg,png,jpeg',
            'page_web' => 'max:255'
        ]);
    }

    /**
     * Create moew user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $administrator=\App\Administrator::where('email',$data['email'])->first();    
        $role_id= 2 ;
        if($administrator){
            $role_id=1;
        }
        $request = request();
        if($request->hasFile('avatar') == true){
            $request->file('avatar','public')->storeAs('/public/profilePicture', $request->get('name_user')); 
        }
        $data['confirmation_code'] = str_random(25);
       $user =  User::create([
            'name_user' => $data['name_user'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthdate' => $data['birthdate'],
            'sex'=>$data['sex'],
            'page_web' => $data['page_web'],
            'role_id'=>$role_id,
            'confirmation_code' => $data['confirmation_code']
        ]);
        // Send confirmation code
        $datas = [
            'name' => $user->name,
            'confirmation_code' => $user->confirmation_code
        ];
        Mail::to($user->email)->send(new send_mail_verify($datas));
        
        return $user;
    }
    public function send_mail_verify(){
        $user = Auth::user();
        if($user->confirmed != true){
           $datas = [
                'name' => $user->name,
                'confirmation_code' => $user->confirmation_code
            ];
            Mail::to($user->email)->send(new send_mail_verify($datas));
        }
         return redirect()->back()->with("mail","Correo de verificacion enviado exitosamente");
    }
    public function verify($code){
        $user = User::where('confirmation_code', $code)->first();
        if (! $user){
            return redirect('/');
        }
        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();
        return redirect('/')->with('notification', 'Has confirmado correctamente tu correo!');
    }

}
