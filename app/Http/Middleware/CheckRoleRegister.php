<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckRoleRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
             if(auth()->user()->role_id==1){
                return $next($request); //role_id=1=admin
             }
             else {
                 return redirect('/');
             }
        }
        else{
           return $next($request); 
        }
        
       
        
    }
}
