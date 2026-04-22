<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

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
$sensor = DB::table('sensore_readings')
    ->latest()
    ->first();
    return view('dashboard', compact(
        'totalBooks',
        'availableBooks',
        'borrowedBooks',
        'lastBorrowed',
        'genreStats',
        'books',
'sensor'
    ));
}

public function latest()
{
    try {
        $data = DB::table('sensore_readings')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json([
            'temperatur' => $data->temperatur ?? null,
            'humidity' => $data->humidity ?? null,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
}
