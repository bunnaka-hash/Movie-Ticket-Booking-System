<?php

namespace App\Http\Requests\Concerns;

use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Validation\Validator;

/**
 * Seat checks shared by the admin counter sale and the customer booking flow:
 * every seat must live in the showtime's hall, and none of them may already be
 * sold. Availability is re-checked at submit time, so two people picking the
 * same seat cannot both succeed.
 */
trait ValidatesSeatAvailability
{
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $showtime = Showtime::find($this->input('showtime_id'));
            $seatIds = $this->input('seat_ids', []);

            if (! $showtime) {
                return;
            }

            $foreignSeats = Seat::whereIn('id', $seatIds)
                ->where('hall_id', '!=', $showtime->hall_id)
                ->count();

            if ($foreignSeats > 0) {
                $validator->errors()->add('seat_ids', 'Some selected seats do not belong to this showtime\'s hall.');

                return;
            }

            $taken = BookingDetail::whereIn('seat_id', $seatIds)
                ->whereHas('booking', fn ($q) => $q->where('showtime_id', $showtime->id)
                    ->where('booking_status', '!=', 'cancelled'))
                ->with('seat')
                ->get()
                ->map(fn ($detail) => $detail->seat->row_name.$detail->seat->seat_number)
                ->implode(', ');

            if ($taken !== '') {
                $validator->errors()->add('seat_ids', "These seats are already booked: {$taken}.");
            }
        });
    }
}
