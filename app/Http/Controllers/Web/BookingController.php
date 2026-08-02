<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreBookingRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Seat map for a screening: the hall's real seats, with anything already
     * sold marked as taken.
     */
    public function seats(Showtime $showtime): View|RedirectResponse
    {
        $showtime->load('movie', 'hall.cinema');

        if (\Illuminate\Support\Carbon::parse($showtime->start_time)->isPast()) {
            return redirect()
                ->route('movies.show', $showtime->movie_id)
                ->with('error', 'That screening has already started.');
        }

        $seats = Seat::where('hall_id', $showtime->hall_id)
            ->orderBy('row_name')
            ->orderByRaw('CAST(seat_number AS UNSIGNED)')
            ->get();

        return view('booking.select-seats', [
            'showtime' => $showtime,
            'seats' => $seats,
            'takenSeatIds' => $this->takenSeatIds($showtime),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $showtime = Showtime::findOrFail($data['showtime_id']);
        $seatIds = $data['seat_ids'];

        $booking = DB::transaction(function () use ($data, $showtime, $seatIds) {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'showtime_id' => $showtime->id,
                'booking_code' => $this->generateBookingCode(),
                'total_price' => $showtime->price * count($seatIds),
                // Payment is collected at the counter for now.
                'booking_status' => 'pending',
                'payment_method' => $data['payment_method'] ?? null,
                'booked_at' => now(),
            ]);

            foreach ($seatIds as $seatId) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seatId,
                    'price' => $showtime->price,
                ]);
            }

            return $booking;
        });

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Your seats are reserved. Booking code '.$booking->booking_code.'.');
    }

    public function index(): View
    {
        $bookings = Booking::with(['showtime.movie', 'showtime.hall.cinema', 'bookingDetails.seat'])
            ->where('user_id', auth()->id())
            ->latest('booked_at')
            ->paginate(10);

        return view('booking.my-tickets', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        $booking->load(['showtime.movie', 'showtime.hall.cinema', 'bookingDetails.seat']);

        return view('booking.confirmation', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if ($booking->booking_status === 'cancelled') {
            return redirect()->route('bookings.index')->with('error', 'That booking was already cancelled.');
        }

        if (\Illuminate\Support\Carbon::parse($booking->showtime->start_time)->isPast()) {
            return redirect()->route('bookings.index')->with('error', 'You cannot cancel a screening that has already started.');
        }

        $booking->update(['booking_status' => 'cancelled']);

        return redirect()
            ->route('bookings.index')
            ->with('success', "Booking {$booking->booking_code} was cancelled and the seats released.");
    }

    private function takenSeatIds(Showtime $showtime)
    {
        return BookingDetail::whereHas('booking', fn ($q) => $q->where('showtime_id', $showtime->id)
            ->where('booking_status', '!=', 'cancelled'))
            ->pluck('seat_id');
    }

    private function generateBookingCode(): string
    {
        do {
            $code = 'BK-'.strtoupper(Str::random(8));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
