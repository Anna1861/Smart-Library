<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorReadingController extends Controller
{
    public function store(Request $request)
    {
        DB::table('sensor_readings')->insert([
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }
}
