<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Administrator extends Model
{
    protected $fillable = ['email','registered'];
    public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
	
}
