<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'county_id',
        'phone',
        'image'
    ];

    public function sender()
    {
        return $this->morphMany(SendInvitation::class, 'sender');
    }
}
