<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;


class BookSeeder extends Seeder
{
   public function run()
{
    $books = [
        ['Harry Potter', 'J.K. Rowling', 1],
        ['Dune', 'Frank Herbert', 3],
        ['Pride and Prejudice', 'Jane Austen', 4],
    ];

    foreach ($books as [$title, $author, $genre]) {
        Book::create([
            'title' => $title,
            'author' => $author,
            'genre_id' => $genre,
        ]);
    }
}

}
