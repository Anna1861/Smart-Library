<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Borrowing;
use App\Models\Location;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'genre_id',
        'section_number',
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

    public function location()
    {
        return $this->belongsTo(Location::class, 'section_number', 'section_number');
    }
}
