<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorReadingController extends Controller
{
    public function store(Request $request)
    {
        // достаём данные
        $data = $request->input('received');

        // защита на случай пустого запроса
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data received'
            ], 400);
        }

        // запись в базу
        DB::table('sensor_readings')->insert([
            'temperature' => $data['temperature'] ?? null,
            'humidity' => $data['humidity'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
