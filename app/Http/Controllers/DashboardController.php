<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Genre;

class DashboardController extends Controller
{
    public function index()
{
    $totalBooks = Book::count();
    $availableBooks = Book::where('is_available', true)->count();
    $borrowedBooks = Book::where('is_available', false)->count();

    $lastBorrowed = Borrowing::with('book')
        ->latest('borrowed_at')
        ->take(3)
        ->get();

    $genreStats = Genre::withCount([
        'books as borrowed_count' => function ($query) {
            $query->where('is_available', false);
        }
    ])->get();

    $books = Book::latest()->take(12)->get();

    return view('dashboard', compact(
        'totalBooks',
        'availableBooks',
        'borrowedBooks',
        'lastBorrowed',
        'genreStats',
        'books' 
    ));
}
}
