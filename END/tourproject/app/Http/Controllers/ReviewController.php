<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use App\Models\Safari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\OptimizesImages;

class ReviewController extends Controller
{
    use OptimizesImages;

    public function index()
    {
        $reviews = Review::with(['tour', 'safari', 'images'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'traveler_name' => 'required|string|max:255',
                'whatsapp_number' => 'required|string|max:20',
                'country' => 'nullable|string|max:255',
                'tour_id' => 'nullable|exists:tours,id',
                'safari_id' => 'nullable|exists:safaris,id',
                'title' => 'nullable|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'description' => 'required|string',
                'images' => 'sometimes|array',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:20480',
            ]);

            if (!empty($validated['tour_id']) && !empty($validated['safari_id'])) {
                return response()->json(['message' => 'Please select either a Tour or Safari, not both.'], 422);
            }

            $review = DB::transaction(function () use ($validated, $request) {
                $review = Review::create(collect($validated)->except('images')->all());

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        $path = $this->storeAndOptimizeImage($file, 'reviews');
                        $review->images()->create([
                            'image_path' => $path,
                        ]);
                    }
                }

                return $review;
            });

            return response()->json([
                'message' => 'Thank you for your review! Your review has been submitted successfully and will become visible after it has been reviewed and approved by our guide/admin.',
                'data' => $review->load('images'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Review Creation Error', ['exception' => $e]);
            return response()->json([
                'message' => 'Error submitting review',
                'error' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
}
