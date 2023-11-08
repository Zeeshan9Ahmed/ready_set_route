<?php

namespace App\Models;

use App\Services\PushNotificationService;
use App\Traits\Friendable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Musonza\Chat\Traits\Messageable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable  , Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'school_id',
        'parent_id',
        'driver_id',
        'role',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image',
        'device_type',
        'device_token',
        'pick_time',
        'drop_time',
        'latitude',
        'longitude',
        'created_by',
        'remember_token',
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schools() 
        {
        return $this->belongsToMany(School::class, 'school_drivers');
        }

        public function parent_school() 
        {
            // return 'ts';
        return $this->hasOne(School::class,  'id' , 'school_id');
        }


    public function myschool()
    {
        return $this->hasOne(School::class);
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
    
    
    
    public function parent()
    {
        return $this->belongsTo(User::class,"parent_id");
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,"driver_id");
    }
    

    public function childrens()
    {
        return $this->hasMany(User::class,"parent_id");
    }

    public function schoolchildrens()
    {
        return $this->hasMany(User::class,"driver_id");
    }
    
    public function student_attendance_status()
    {
        return $this->hasOne(Ort::class,'user_id','id')->whereDate('date', getCurrentDate())->latest('id');
    }
    
    
    public function attendance()
    {
        return $this->hasMany(Ort::class,"user_id")->latest('date');
    }
}
