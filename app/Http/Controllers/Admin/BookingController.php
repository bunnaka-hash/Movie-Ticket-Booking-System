<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookingRequest;
use App\Http\Requests\Admin\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $bookings = Booking::with(['user', 'showtime.movie', 'showtime.hall', 'bookingDetails.seat'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(fn ($q) => $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")));
            })
            ->when($request->filled('status'), fn ($q) => $q->where('booking_status', $request->status))
            ->latest('booked_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['user', 'showtime.movie', 'showtime.hall.cinema', 'bookingDetails.seat']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Counter sale. The seat picker needs a showtime first, so the page works
     * in two passes: choose a showtime, then pick from that hall's free seats.
     */
    public function create(Request $request): View
    {
        $showtime = $request->filled('showtime_id')
            ? Showtime::with('movie', 'hall.cinema')->find($request->showtime_id)
            : null;

        return view('admin.bookings.create', [
            'customers' => User::orderBy('name')->get(['id', 'name', 'email', 'role']),
            'showtimes' => Showtime::with('movie', 'hall.cinema')
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->get(),
            'showtime' => $showtime,
            'seats' => $showtime ? $this->seatsFor($showtime) : collect(),
            'takenSeatIds' => $showtime ? $this->takenSeatIds($showtime) : collect(),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $showtime = Showtime::findOrFail($data['showtime_id']);
        $seatIds = $data['seat_ids'];

        $booking = DB::transaction(function () use ($data, $showtime, $seatIds) {
            $booking = Booking::create([
                'user_id' => $data['user_id'],
                'showtime_id' => $showtime->id,
                'booking_code' => $this->generateBookingCode(),
                'total_price' => $showtime->price * count($seatIds),
                'booking_status' => $data['booking_status'],
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
            ->route('admin.bookings.show', $booking)
            ->with('success', "Booking {$booking->booking_code} was created.");
    }

    public function edit(Booking $booking): View
    {
        $booking->load(['user', 'showtime.movie', 'showtime.hall', 'bookingDetails.seat']);

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $data = $request->validated();
        $checkedIn = (bool) ($data['checked_in'] ?? false);

        // A cancelled ticket must not stay flagged as checked in.
        if ($data['booking_status'] === 'cancelled') {
            $checkedIn = false;
        }

        $booking->update([
            'booking_status' => $data['booking_status'],
            'payment_method' => $data['payment_method'] ?? null,
            'checked_in_at' => $checkedIn ? ($booking->checked_in_at ?? Carbon::now()) : null,
        ]);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} was updated.");
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $code = $booking->booking_code;
        $booking->delete(); // booking_details cascade away with it

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', "Booking {$code} was deleted and its seats released.");
    }

    private function seatsFor(Showtime $showtime)
    {
        return Seat::where('hall_id', $showtime->hall_id)
            ->orderBy('row_name')
            ->orderByRaw('CAST(seat_number AS UNSIGNED)')
            ->get();
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
