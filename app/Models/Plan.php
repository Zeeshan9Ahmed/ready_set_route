<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable =  [
        'title' ,
        'description',
        'price',
        'off' ,
        'type',
    ];
    use HasFactory;

    public function features()
    {
        return $this->hasMany(PlanFeature::class);
    }
}
