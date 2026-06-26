<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Safari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\OptimizesImages;

class SafariManagementController extends Controller
{
    use OptimizesImages;
    public function index()
    {
        return response()->json(Safari::with('images')->get());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'highlights' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'duration' => 'required|string|max:255',
                'included' => 'required|string',
                'itinerary' => 'required|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            $safari = DB::transaction(function () use ($validated, $request) {
                $safari = Safari::create(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'safaris');
                        $safari->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }

                return $safari;
            });

            return response()->json(['message' => 'Safari created successfully', 'data' => $safari->load('images')], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Safari Creation Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error creating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function show(Safari $safari)
    {
        return response()->json($safari->load('images'));
    }

    public function update(Request $request, Safari $safari)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'highlights' => 'sometimes|string',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric',
                'duration' => 'sometimes|string|max:255',
                'included' => 'sometimes|string',
                'itinerary' => 'sometimes|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            DB::transaction(function () use ($validated, $request, $safari) {
                $safari->update(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'safaris');
                        $safari->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'Safari updated successfully', 'data' => $safari->load('images')]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Safari Update Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error updating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function destroy(Safari $safari)
    {
        $safari->images->each->delete();
        $safari->delete();
        return response()->json(['message' => 'Safari deleted successfully']);
    }
}
