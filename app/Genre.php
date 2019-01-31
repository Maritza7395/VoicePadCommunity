<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Genre extends Model
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
    public function summernote(){
         return $this->hasOne('App\Summernote');
    }
    public function scopeReport($query, $limit,$order){  
        if($limit != " " && $order != " "){
            return DB::table('summernotes')
                ->select(DB::raw('COUNT( summernotes.genre_id) as countGenre , summernotes.genre_id as genre_id '))
                ->orderBy('countGenre', $order)            
                ->groupBy('genre_id')
                ->limit($limit)
                ->get();  
            }   
    
    }
}
