<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['state_name'];
    public function counties()
    {
        return $this->hasMany(County::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
