<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function cookies(){
    	return view('policy.cookies');
    }
     public function conditions(){
    	return view('policy.conditions');
    }
}
