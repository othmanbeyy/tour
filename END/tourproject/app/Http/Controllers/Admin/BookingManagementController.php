<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['tour', 'safari'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function show($id)
    {
        $booking = Booking::with(['tour', 'safari'])->findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed,rejected',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully.',
            'data' => $booking->fresh(['tour', 'safari']),
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully.',
        ]);
    }
}
