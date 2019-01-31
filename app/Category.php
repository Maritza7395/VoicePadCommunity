<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Category extends Model
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
    public function summernotes()
    {
        return $this->belongsToMany('App\Summernote','asigned_categories');
    }
    public function scopeReport($query, $limit,$order){  
        if($limit != " " && $order != " "){
            return DB::table('asigned_categories')
                ->select(DB::raw('COUNT( asigned_categories.category_id) as countCategory , asigned_categories.category_id as category_id '))
                ->orderBy('countCategory', $order)            
                ->groupBy('category_id')
                ->limit($limit)
                ->get();  
            }   
    
    }
}
