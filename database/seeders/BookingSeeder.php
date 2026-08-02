<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates a handful of bookings against real showtimes and real seats of
     * the matching hall, so the seat map, check-in and reporting screens all
     * have something to display.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->orderBy('id')->get();

        // Mix finished and upcoming shows so both the check-in screen and the
        // "my upcoming tickets" screen have data.
        $past = Showtime::with('hall')
            ->where('start_time', '<', now())
            ->orderByDesc('start_time')
            ->limit(4)
            ->get();

        $upcoming = Showtime::with('hall')
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $showtimes = $past->concat($upcoming);

        if ($customers->isEmpty() || $showtimes->isEmpty()) {
            $this->command?->warn('No customers or showtimes found, skipping bookings.');
            return;
        }

        $statuses = ['paid', 'paid', 'pending', 'paid', 'cancelled'];
        $methods = ['aba', 'card', null, 'wing', 'cash'];
        $counter = 0;

        foreach ($showtimes as $showtime) {
            $seats = Seat::where('hall_id', $showtime->hall_id)
                ->orderBy('row_name')
                ->orderByRaw('CAST(seat_number AS UNSIGNED)')
                ->get();

            if ($seats->isEmpty()) {
                continue;
            }

            // Two bookings per showtime, each on a distinct block of seats.
            for ($n = 0; $n < 2; $n++) {
                $seatCount = $n === 0 ? 2 : 3;
                $offset = $n === 0 ? 0 : 5;
                $bookingSeats = $seats->slice($offset, $seatCount);

                if ($bookingSeats->count() < $seatCount) {
                    continue;
                }

                $status = $statuses[$counter % count($statuses)];
                $bookedAt = Carbon::parse($showtime->start_time)->subDays(2);

                $booking = Booking::create([
                    'user_id' => $customers[$counter % $customers->count()]->id,
                    'showtime_id' => $showtime->id,
                    'booking_code' => 'BK-' . strtoupper(Str::random(6)) . str_pad((string) $counter, 2, '0', STR_PAD_LEFT),
                    'total_price' => $showtime->price * $seatCount,
                    'booking_status' => $status,
                    'payment_method' => $methods[$counter % count($methods)],
                    'booked_at' => $bookedAt,
                    // Only a paid ticket for a show that already started is checked in.
                    'checked_in_at' => $status === 'paid' && Carbon::parse($showtime->start_time)->isPast()
                        ? Carbon::parse($showtime->start_time)->subMinutes(10)
                        : null,
                ]);

                foreach ($bookingSeats as $seat) {
                    BookingDetail::create([
                        'booking_id' => $booking->id,
                        'seat_id' => $seat->id,
                        'price' => $showtime->price,
                    ]);
                }

                $counter++;
            }
        }
    }
}
