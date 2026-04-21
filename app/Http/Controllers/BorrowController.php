<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Models\Genre;

class BorrowController extends Controller
{
    public function index()
    {
$books = Book::where('is_available', true)->get();
$borrowedBooks = Book::where('is_available', false)->get();
$genres = Genre::all();

return view('borrow.index', compact('books', 'borrowedBooks', 'genres'));
    }

    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->is_available) {
            return back()->with('error', 'Dieses Buch ist bereits ausgeliehen.');
        }

        Borrowing::create([
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        $book->update([
            'is_available' => false,
        ]);

        return back()->with('success', 'Buch wurde erfolgreich ausgeliehen.');
    }
}
