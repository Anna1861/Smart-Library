<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorReadingController extends Controller
{
    public function store(Request $request)
    {
        try {

            // получаем любые данные (без зависимостей от формата)
            $data = $request->all();

            // если пришла строка JSON — распарсим
            if (empty($data) || count($data) === 0) {
                $data = json_decode($request->getContent(), true);
            }

            // если вдруг есть лишний слой
            if (isset($data['received'])) {
                $data = $data['received'];
            }

            DB::table('sensore_readings')->insert([
    'temperatur' => $data['temperature'] ?? 0,
    'humidity' => $data['humidity'] ?? 0,
    'created_at' => now(),
    'updated_at' => now(),
]);

            return response()->json([
                'status' => 'ok'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
