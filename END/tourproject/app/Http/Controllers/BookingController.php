<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\Safari;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'nullable|exists:tours,id',
            'safari_id' => 'nullable|exists:safaris,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
            'special_requests' => 'nullable|string',
            'number_of_tourists' => 'required|integer|min:1',
            'children_count' => 'nullable|integer|min:0',
            'booking_date' => 'nullable|date',
        ]);

        if (!$request->tour_id && !$request->safari_id) {
            return response()->json([
                'message' => 'You must select either a Tour or Safari'
            ], 422);
        }

        $booking = Booking::create($validated);

        // Build WhatsApp Message
        $message = "New Booking Received\n\n";
        $message .= "Name: {$booking->first_name} {$booking->last_name}\n";
        $message .= "Email: {$booking->email}\n";
        $message .= "Phone: {$booking->phone}\n";
        if (!empty($booking->country)) {
            $message .= "Country: {$booking->country}\n";
        }
        $message .= "\n";
        
        if (!empty($validated['tour_id'])) {
            $tour = Tour::find($validated['tour_id']);
            $message .= "Tour: {$tour->title}\n";
        } elseif (!empty($validated['safari_id'])) {
            $safari = Safari::find($validated['safari_id']);
            $message .= "Safari: {$safari->title}\n";
        }

        $message .= "Number of Travelers: {$booking->number_of_tourists}\n";
        
        if (!empty($booking->children_count)) {
            $message .= "Number of Children: {$booking->children_count}\n";
        }
        
        if (!empty($booking->booking_date)) {
            $message .= "Booking Date: {$booking->booking_date}\n";
        }
        
        if (!empty($booking->special_requests)) {
            $message .= "\nSpecial Requests:\n{$booking->special_requests}\n";
        }

        $encodedMessage = urlencode($message);
        
        // WhatsApp Admin Number
        $adminNumber = "255636578018";
        $whatsappUrl = "https://wa.me/{$adminNumber}?text={$encodedMessage}";

        return response()->json([
            'message' => 'Booking submitted successfully.',
            'data' => $booking,
            'whatsapp_url' => $whatsappUrl
        ], 201);
    }
}
