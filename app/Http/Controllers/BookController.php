<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;


class BookController extends Controller
{
    public function index()
    {
$books = ('sjs');
    // $books = Book::with('genre')->get();
        return view('books.index', compact('books'));
    }

    public function borrow(Book $book)
    {
        if (!$book->is_available) {
            return back();
        }

        Borrowing::create([
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        $book->update(['is_available' => false]);

        return back();
    }

    public function return(Book $book)
    {
        $borrowing = $book->borrowings()->whereNull('returned_at')->latest()->first();

        if ($borrowing) {
            $borrowing->update(['returned_at' => now()]);
            $book->update(['is_available' => true]);
        }

        return back();
    }

}

