<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintText extends Model
{
    protected $table = 'complaint_texts';
    protected $fillable = [
        'denied',
        'status'

    ];
    
    
    // public function getCreatedAtAttribute($value)
    // {
    //      return Carbon::parse($value)->format('d/m/Y');
    // }
     public function summernote()
    {
        $this->belongsTo('App\Summernote', 'summernote_id', 'summernote_id');
    }

    public function user()
    {
        $this->belongsTo('App\User', 'name_user_id', 'name_user_id');
    }
    //la denuncia solo puede tener un motivo y viceversa
    public function motivation_text()
    {
        $this->hasOne('App\MotivationText');
    }
}
