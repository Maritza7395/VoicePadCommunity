<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MotivationUser extends Model
{
	protected $fillable = ['name','description'];
	public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    
    public function getUpdatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    public function motivation_users()
    {
    	return $this->hasOne('App\ComplaintUser');
    }
}
