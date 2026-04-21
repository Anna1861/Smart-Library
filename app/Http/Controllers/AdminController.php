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
    $data = $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'genre_id' => 'required|exists:genres,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('books', 'public');
        $data['image'] = $path;
    }

    $data['is_available'] = true;

    Book::create($data);

    return redirect()->back()->with('success', 'Book created successfully.');
}
}
