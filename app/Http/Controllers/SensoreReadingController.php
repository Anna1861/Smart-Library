<?php

namespace App\Http\Controllers;

use App\Models\SensoreReading;
use Illuminate\Http\Request;

class SensoreReadingController extends Controller
{
    public function latest()
    {
        return SensoreReading::latest()->first();
    }
}
