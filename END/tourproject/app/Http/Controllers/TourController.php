<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with('images')->get();
        return response()->json($tours);
    }

    public function showBySlug($slug)
    {
        $tour = Tour::with('images')->where('slug', $slug)->firstOrFail();
        return response()->json($tour);
    }

    public function show($id)
    {
        $tour = Tour::with('images')->findOrFail($id);
        return response()->json($tour);
    }
}
