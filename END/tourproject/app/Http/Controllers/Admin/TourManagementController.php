<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\OptimizesImages;

class TourManagementController extends Controller
{
    use OptimizesImages;
    public function index()
    {
        return response()->json(Tour::with('images')->get());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'duration' => 'required|string|max:255',
                'itinerary' => 'required|string',
                'included' => 'nullable|string',
                'excluded' => 'nullable|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            $tour = DB::transaction(function () use ($validated, $request) {
                $tour = Tour::create(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'tours');
                        $tour->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }

                return $tour;
            });

            return response()->json(['message' => 'Tour created successfully', 'data' => $tour->load('images')], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Tour Creation Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error creating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function show(Tour $tour)
    {
        return response()->json($tour->load('images'));
    }

    public function update(Request $request, Tour $tour)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric',
                'duration' => 'sometimes|string|max:255',
                'itinerary' => 'sometimes|string',
                'included' => 'nullable|string',
                'excluded' => 'nullable|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            DB::transaction(function () use ($validated, $request, $tour) {
                $tour->update(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'tours');
                        $tour->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }
            });

            return response()->json(['message' => 'Tour updated successfully', 'data' => $tour->load('images')]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Tour Update Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error updating record',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function destroy(Tour $tour)
    {
        $tour->images->each->delete();
        $tour->delete();
        return response()->json(['message' => 'Tour deleted successfully']);
    }
}
