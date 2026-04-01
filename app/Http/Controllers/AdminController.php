<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;

class AdminController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        $books = Book::all();
        return view('admin.index', compact('genres', 'books'));
    }

    public function storeGenre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name',
        ]);

        Genre::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Genre created successfully.');
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'genre_id' => $request->genre_id,
            'is_available' => true,
        ]);

        return redirect()->back()->with('success', 'Book created successfully.');
    }
}
