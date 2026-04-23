<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['section_number', 'desc'];

    public function book()
    {
        return $this->hasOne(Book::class, 'section_number', 'desc');
    }
}
