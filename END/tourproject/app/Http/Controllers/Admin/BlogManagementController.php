<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\OptimizesImages;

class BlogManagementController extends Controller
{
    use OptimizesImages;

    public function index()
    {
        return response()->json(Blog::with(['images', 'author'])->latest()->get());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'nullable|string|max:1000',
                'content' => 'required|string',
                'location' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:100',
                'tags' => 'nullable|string',
                'duration' => 'nullable|string|max:100',
                'status' => 'in:draft,published',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            $validated['slug'] = Str::slug($validated['title']);
            $validated['author_id'] = auth()->id();
            $validated['status'] = $validated['status'] ?? 'draft';

            if (isset($validated['tags']) && is_string($validated['tags'])) {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            }

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

            return response()->json(['message' => 'Blog created successfully', 'data' => $blog->load(['images', 'author'])], 201);
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
        return response()->json($blog->load(['images', 'author']));
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'excerpt' => 'nullable|string|max:1000',
                'content' => 'sometimes|string',
                'location' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:100',
                'tags' => 'nullable|string',
                'duration' => 'nullable|string|max:100',
                'status' => 'in:draft,published',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            if (isset($validated['title']) && !$blog->slug) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            if (isset($validated['tags']) && is_string($validated['tags'])) {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            }

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

            return response()->json(['message' => 'Blog updated successfully', 'data' => $blog->load(['images', 'author'])]);
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
