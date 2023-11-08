<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;


class School extends Authenticatable
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'image',
        'school_name',
        'shoool_image',
        'school_phone',
        'address',
        'latitude',
        'longitude',
        'description',
        'county_id',
        'invited_by',
    ];
    use HasFactory;

    public function sender()
    {
        return $this->morphMany(SendInvitation::class, 'sender');
    }
    
     public function childrens()
    {
        return $this->hasMany(User::class,"school_id")->where("role","student");
    }
     public function school()
    {
        return $this->belongsTo(School::class);
    }
    
   

}
