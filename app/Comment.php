<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Comment extends Model
{
    use SoftDeletes;
    use CascadeSoftDeletes;
   
   protected $CascadeSoftDeletes = ['comments_reponse','user','summernote']; //indica la relación posts()
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id','description'];
public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    public function comments_reponse()
    {
        return $this->hasMany('App\CommentResponse');

    }
    public function user()
    {
        return $this->belongsto('App\User');

    }
    public function summernote()
    {
        return $this->belongsto('App\Summernote');
    }
   

}
