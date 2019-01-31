<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paper extends Model
{
	protected $fillable=['content'];

    public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    public function summernote()
    {
        return $this->belongsTo('App\Summernote');
    }
    public function scopeContent($query, $content)
    {
        if($content){
               return $query->whereRaw("MATCH(content) AGAINST(?)", $content);
            // return $query->whereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", array($content));
        }
    }
}
