<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;


class StaffController extends Controller
{
    public function todayBookings()
    {
        $bookings = Booking::with([
            'user',
            'showtime.movie',
            'showtime.hall',
            'bookingDetails.seat'
        ])
        ->whereDate('booked_at', today())
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => "Today's bookings retrieved successfully.",
            'data' => BookingResource::collection($bookings),
        ]);
    }

    public function checkIn(Booking $booking)
    {
        if ($booking->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Customer has already checked in.',
            ], 422);
        }

        $booking->update([
            'checked_in_at' => now(),
        ]);

        $booking->load([
            'user',
            'showtime.movie',
            'showtime.hall',
            'bookingDetails.seat',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer checked in successfully.',
            'data' => new BookingResource($booking),
        ]);
    }
}