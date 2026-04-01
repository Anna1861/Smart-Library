<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre; 



class GenreSeeder extends Seeder
{
    public function run()
{
    $genres = [
        'Fantasy',
        'Drama',
        'Sci-Fi',
        'Romance',
        'Detective'
    ];

    foreach ($genres as $genre) {
        Genre::create(['name' => $genre]);
    }
}

}
