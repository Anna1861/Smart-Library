<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['section_number', 'desc'];

    public function books()
    {
        return $this->hasMany(Book::class, 'section_number', 'section_number');
    }
}
