<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendInvitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_type',
        'sender_id',
        'name',
        'invite-to',
        'email',
        'phone_number',
        'location',
        'admin_id',
        'code',
        'status',
        'county_id',
        'invite_link'
    ];

    public function sender()
    {
        return $this->morphTo('sender');
    }
}
