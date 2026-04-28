<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            Location::updateOrCreate(
                ['id' => $i],
                [
                    'section_number' => $i,
                    'desc' => 'Section ' . $i,
                ]
            );
        }
    }
}
