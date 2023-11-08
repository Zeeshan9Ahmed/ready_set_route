<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $fillable = ['state_id','county_name'];
    use HasFactory;

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
