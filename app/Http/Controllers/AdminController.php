<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Location;
use Cloudinary\Cloudinary;


class AdminController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        $books = Book::all();
        $locations = Location::all();
        return view('admin.index', compact('genres', 'books', 'locations'));
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
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'desc' => 'nullable|string'
    ]);

    if ($request->hasFile('image')) {

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dherzxgwp',
                'api_key' => '661234765825222',
                'api_secret' => 'wXTBgPOZsrC3OIw17vGD8jauUJ4'
            ]
        ]);

        $uploaded = $cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'books']
        );

        $data['image'] = $uploaded['secure_url'];
    }

    $data['is_available'] = true;

    Book::create($data);

    return redirect()->back()->with('success', 'Book created successfully.');
}
}
