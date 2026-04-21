<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensoreReading extends Model
{
    protected $fillable = ['humidity', 'temperatur'];
    
}
