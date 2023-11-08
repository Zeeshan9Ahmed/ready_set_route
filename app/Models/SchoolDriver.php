<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDriver extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'driver_id',
        'status'
    ];
}
