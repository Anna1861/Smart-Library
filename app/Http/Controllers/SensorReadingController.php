<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorReadingController extends Controller
{
public function store(Request $request)
{
    return response()->json([
        'received' => $request->all()
    ]);
}
}
