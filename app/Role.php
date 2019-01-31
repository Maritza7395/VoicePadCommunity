<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Role extends Model
{
	public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    public function getUpdatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    //Relacion uno a uno user-rol
    public function user(){
         return $this->hasOne('App\User');
    }
}
