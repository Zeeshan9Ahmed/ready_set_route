<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_id',
        'reciever_id',
        'model_type_id',
        'title',
        'description',
        'data',
        'created_at',
        'updated_at',
        'sender_type',
        'reciever_type',
        'notification_type'
        
    ];
}
