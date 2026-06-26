<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('images')->get();
        return response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::with('images')->findOrFail($id);
        return response()->json($blog);
    }
}
