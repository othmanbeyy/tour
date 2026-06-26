<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\OptimizesImages;

class BlogManagementController extends Controller
{
    use OptimizesImages;
    public function index()
    {
        return response()->json(Blog::with('images')->get());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            $blog = DB::transaction(function () use ($validated, $request) {
                $blog = Blog::create(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'blogs');
                        $blog->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }

                return $blog;
            });

            return response()->json(['message' => 'Blog created successfully', 'data' => $blog->load('images')], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Blog Creation Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error creating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function show(Blog $blog)
    {
        return response()->json($blog->load('images'));
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            DB::transaction(function () use ($validated, $request, $blog) {
                $blog->update(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'blogs');
                        $blog->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'Blog updated successfully', 'data' => $blog->load('images')]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Blog Update Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error updating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function destroy(Blog $blog)
    {
        $blog->images->each->delete();
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
