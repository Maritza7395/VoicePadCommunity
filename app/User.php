<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    // use SoftCascadeTrait;
    use CascadeSoftDeletes;

    protected $CascadeSoftDeletes = ['commands','complaint_user','followed','summernotes','scores_summernotes','favorites_summernotes','comments','complaint_summernote','comment_responses','views']; //indica la relación posts()
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_user','name', 'last_name','about_me','email','password','role_id','sex','birthdate','page_web','confirmation_code'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'password', 'remember_token',
    ];

    protected static function boot() 
    {
      parent::boot();

      static::deleting(function($users) {
        foreach ($users->summernotes()->get() as $summernotes) {                   
            $summernotes->delete();
         }
         foreach ($users->comments()->get() as $comments) {
            $comments->delete();
         }
         foreach ($users->comments_response()->get() as $comments) {
            $comments->delete();
         }
          
      });
    }

    public function getCreatedAtAttribute($value)
    {
         return Carbon::parse($value)->format('d/m/Y');
    }
    //Relacion uno a uno user-rol
    public function role(){
         return $this->hasOne('App\Role')->withTimestamps();
         //belongsto
    }
     public function summernotes(){
        return $this->hasMany('App\Summernote');
    }
    //Relacion mucho a muchos un usuario puede tener muchos textos favoritos
    public function favorites_summernotes()
    {
        return $this->belongsToMany('App\Summernote','text_favorites')->withTimestamps();
    }
    //Relacion un usuario puede puntuar muchos libros
    public function scores_summernotes()
    {
        return $this->belongsToMany('App\Summernote','scores','name_user_id','summernote_id')->withTimestamps();
    }
    public function complaint_summernote()
    {
        return $this->belongsToMany('App\Summernote','complaint_texts','user_id','summernote_id')->withTimestamps();
    }
    // public function complaint_motivation_summernote()
    // {
    //     return $this->belongsToMany('App\MotivationUser','complaint_texts','user_id','summernote_id');
    // }
    //Relacion con commandos de vos, muchos a muchos
    public function commands()
    {
        return $this->belongsToMany('App\Command','customized_commands')->withPivot('customized_command')->withTimestamps();
    }
    //Comentar textos
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
     public function views()
    {
        return $this->belongsToMany('App\Summernote','views','user_id','summernote_id')->withTimestamps();

    }
    public function comments_response()
    {
        return $this->hasMany('App\CommentResponse');
    }
    //Relacion Denuncia-User
    public function complaint_user() //Usuario Denuncia  Usuario
    {
        return $this->belongsToMany('App\User','complaint_users','user_id','user_complaint_id')->withTimestamps();
    }
    public function complaint(){
        return $this->belongsToMany('App\MotivationUser','complaint_users','user_id','motivation_user_id')->withTimestamps();
    }
    public function user_complaint() //recopilacion de quienes te han denunciado
    {
        return $this->belongsToMany('App\User','complaint_users','user_complaint_id','user_id')->withTimestamps()->withPivot('motivation_user_id');
    }
    //Relacion seguidor sigue a muchos seguidores
    public function followed(){//seguidos son los que yo sigo
        return $this->belongsToMany('App\User','followers','user_id','user_follow_id')->withTimestamps();
    }
    public function followers(){//seguidores son quienes me siguen
        return $this->belongsToMany('App\User','followers','user_follow_id','user_id')->withTimestamps();
    }
     public function alerts(){
        return $this->belongsToMany('App\User','alerts','user_id','user_id_admin')->withTimestamps();
    }    
    public  function sendPasswordResetNotification($token){
        $this->notify(new ResetPasswordNotification($token));
    }
    public function existPicturePerfil($name_user, $sex){
        $boolExist= Storage::exists('/public/profilePicture/'.$name_user);
        if($boolExist){
             $route=asset('storage/profilePicture/'.$name_user);
        }
        elseif ($sex == 'M') {
           $route=asset('storage/profilePicture/defaultM');
        }
        else{
            $route=asset('storage/profilePicture/defaultF');           
        }
        return $route;
    }
    public function scopeDate($query, $dateStart , $dateEnd){
        if($dateEnd != " " && $dateStart != " "){
            return $query->whereBetween('created_at', [$dateStart, $dateEnd]);
        }

    }
     public function scopeName($query, $name)    
    {
        if($name != " "){
            return $query->where('name_user', 'LIKE', "%$name%");
        }
    }
    public function dateStartComplaint(){
        $complaint =  \App\ComplaintUser::orderBy('created_at','asc')->first();
       return $complaint->created_at;
    }
    public function scopeComplaints($query, $limit,$order,$dateStart , $dateEnd){
        $user=Auth::user();
        if($limit==0){
            $limit=null;
        } 
       if($dateEnd == null){
            $dateEnd = Carbon::today()->addDay();
        }
        else{
            $dateEnd = Carbon::parse($dateEnd)->addDay()->format('Y-m-d');
        }
        if($dateStart == null){
            $dateStart = $this->dateStartComplaint();
        }
        if($limit != " " && $order != " " && $dateEnd != null && $dateStart != null){
            return DB::table('complaint_users')
                ->select(DB::raw('COUNT( complaint_users.user_complaint_id) as countComplaints , complaint_users.user_complaint_id as idUser '))
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('countComplaints', $order)            
                ->groupBy('idUser')
                ->limit($limit)
                ->get();  
        }  
    }
    public function scopeSummernote($query, $limit,$order){
        if($limit==0){
            $limit=null;
        } 
        if($limit != " " && $order != " "){
            return DB::table('summernotes')
                ->select(DB::raw('COUNT( summernotes.user_id) as countSummernotes , summernotes.user_id as idUser '))
                ->orderBy('countSummernotes', $order)            
                ->groupBy('idUser')
                ->limit($limit)
                ->get();  
            }   
    }
    public function scopeFollows($query, $limit, $order){
        if($limit==0){
            $limit=null;
        } 
        if($limit != " " && $order != " "){
            return DB::table('followers')
                ->select(DB::raw('COUNT( followers.user_follow_id) as countUser , followers.user_follow_id as idUser '))
                ->orderBy('countUser', $order)
            //->whereBetween('created_at', [Carbon::today()->subWeek()->format('Y-m-d'),Carbon::today()->format('Y-m-d')])
                ->groupBy('idUser')
                ->limit($limit)
                ->get();
            }       
        
    }
}
