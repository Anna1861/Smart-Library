<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Borrowing;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'genre_id',
        'is_available',
        'image',
        'desc'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}


