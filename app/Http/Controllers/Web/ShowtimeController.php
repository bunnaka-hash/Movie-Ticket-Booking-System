<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\BookingDetail;

class ShowtimeController extends Controller
{
    public function selectSeats(Showtime $showtime)
    {
        // eager load relations
        $showtime->load('hall.seats', 'movie');

        // find reserved seat identifiers for this showtime
        $reserved = BookingDetail::whereHas('booking', function ($q) use ($showtime) {
            $q->where('showtime_id', $showtime->id);
        })->with('seat')->get()->pluck('seat')->filter()->map(function ($seat) {
            return ($seat->row_name ?? '') . ($seat->seat_number ?? '');
        })->toArray();

        return view('pages.bookings.seat-selection', compact('showtime', 'reserved'));
    }
}
