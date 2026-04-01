<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Book;

class Borrowing extends Model
{
    protected $fillable = [
        'book_id',
        'borrowed_at',
        'returned_at'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

