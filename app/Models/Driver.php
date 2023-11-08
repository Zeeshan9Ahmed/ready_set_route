<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'name',
        'role',
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
    ];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_drivers');
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'user_id','id');
    }

    public function schoolchildrens()
    {
        return $this->hasMany(User::class,"driver_id");
    }

}
