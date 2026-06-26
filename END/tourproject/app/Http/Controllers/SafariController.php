<?php

namespace App\Http\Controllers;

use App\Models\Safari;
use Illuminate\Http\Request;

class SafariController extends Controller
{
    public function index()
    {
        $safaris = Safari::with('images')->get();
        return response()->json($safaris);
    }

    public function show($id)
    {
        $safari = Safari::with('images')->findOrFail($id);
        return response()->json($safari);
    }
}
