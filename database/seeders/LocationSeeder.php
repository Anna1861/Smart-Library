<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['section_number' => '1', 'desc' => 'Художественная литература'],
            ['section_number' => '2', 'desc' => 'Классика'],
            ['section_number' => '3', 'desc' => 'Поэзия'],
            ['section_number' => '4', 'desc' => 'Фантастика'],
            ['section_number' => '5', 'desc' => 'Детективы'],
            ['section_number' => '6', 'desc' => 'Приключения'],
            ['section_number' => '7', 'desc' => 'Научная литература'],
            ['section_number' => '8', 'desc' => 'История'],
            ['section_number' => '9', 'desc' => 'Биографии'],
            ['section_number' => '10', 'desc' => 'Детская литература'],
            ['section_number' => '11', 'desc' => 'Учебники'],
            ['section_number' => '12', 'desc' => 'Справочники'],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['section_number' => $location['section_number']],
                $location
            );
        }
    }
}
