<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewManagementController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['tour', 'safari', 'images'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    public function show($id)
    {
        $review = Review::with(['tour', 'safari', 'images'])->findOrFail($id);
        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully.',
            'data' => $review->fresh(['tour', 'safari', 'images']),
        ]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully.',
        ]);
    }
}
