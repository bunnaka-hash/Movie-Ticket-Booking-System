<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\BookingResource;


class BookingController extends Controller
{
    public function book(StoreBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $showtime = Showtime::with('hall')->findOrFail($request->showtime_id);

            $seats = Seat::whereIn('id', $request->seat_ids)->get();

            foreach ($seats as $seat) {
                if ($seat->hall_id != $showtime->hall_id) {
                    abort(422, 'One or more selected seats do not belong to this hall.');
                }
            }

            $bookedSeatIds = BookingDetail::whereHas('booking', function ($query) use ($showtime) {
                $query->where('showtime_id', $showtime->id)
                    ->where('booking_status', '!=', 'cancelled');
            })
            ->whereIn('seat_id', $request->seat_ids)
            ->pluck('seat_id');

            if ($bookedSeatIds->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more selected seats are already booked.',
                    'booked_seats' => $bookedSeatIds,
                ], 422);
            }

            $totalPrice = $showtime->price * count($request->seat_ids);

            $bookingCode = 'BK-' . strtoupper(Str::random(8));

            $booking = Booking::create([
                'user_id' => auth()->id(),                // Replace with auth()->id() after authentication
                'showtime_id' => $showtime->id,
                'booking_code' => $bookingCode,
                'total_price' => $totalPrice,
                'booking_status' => 'pending',
                'payment_method' => $request->payment_method,
                'booked_at' => Carbon::now(),
            ]);

            foreach ($seats as $seat) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat->id,
                    'price' => $showtime->price,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'data' => $booking->load([
                    'showtime.movie',
                    'showtime.hall',
                    'bookingDetails.seat',
                ]),
                
            ], 201);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with([
            'showtime.movie',
            'showtime.hall',
            'bookingDetails.seat',
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Bookings retrieved successfully.',
            'data' => BookingResource::collection($bookings),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $booking->load([
            'showtime.movie',
            'showtime.hall',
            'bookingDetails.seat',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking retrieved successfully.',
            'data' => new BookingResource($booking),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        if ($booking->booking_status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Booking has already been cancelled.',
            ], 422);
        }

        $booking->update([
            'booking_status' => 'cancelled',
        ]);

        $booking->load([
            'showtime.movie',
            'showtime.hall',
            'bookingDetails.seat',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully.',
            'data' => new BookingResource($booking),
        ]);
    }
}
