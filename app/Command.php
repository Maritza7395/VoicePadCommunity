<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Command extends Model
{
	protected $fillable = ['name','description'];
	//los comandos pertenecen a muchas personas
	public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
     public function getUpdatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    public function commands()
    {
        return $this->belongsToMany('App\User','customized_commands','command_id','name_user_id');
    }
}
