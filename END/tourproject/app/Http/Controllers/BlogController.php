<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->with('images')->latest()->get();
        return response()->json($blogs);
    }

    public function showBySlug($slug)
    {
        $blog = Blog::published()->with('images')->where('slug', $slug)->firstOrFail();
        return response()->json($blog);
    }

    public function show($id)
    {
        $blog = Blog::published()->with('images')->findOrFail($id);
        return response()->json($blog);
    }
}
