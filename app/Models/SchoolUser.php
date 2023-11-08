<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    protected $table = 'school_user';
    use HasFactory;
    protected $fillable = [
        'school_id',
        'user_id',
        'time',
        'description',
        'status',
    ];
}
