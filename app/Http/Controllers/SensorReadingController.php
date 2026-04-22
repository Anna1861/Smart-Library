<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorReadingController extends Controller
{
    public function store(Request $request)
    {
        // берём данные напрямую (самый надёжный способ)
        $temperature = $request->input('temperature');
        $humidity = $request->input('humidity');

        // если вдруг пришёл JSON строкой
        if (!$temperature && !$humidity) {
            $data = json_decode($request->getContent(), true);

            $temperature = $data['temperature'] ?? null;
            $humidity = $data['humidity'] ?? null;
        }

        // защита
        if ($temperature === null || $humidity === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid payload'
            ], 400);
        }

        // запись в базу
        DB::table('sensor_readings')->insert([
            'temperature' => $temperature,
            'humidity' => $humidity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
