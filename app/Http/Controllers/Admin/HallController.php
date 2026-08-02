<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHallRequest;
use App\Http\Requests\UpdateHallRequest;
use App\Models\BookingDetail;
use App\Models\Cinema;
use App\Models\Hall;
use App\Support\SeatLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HallController extends Controller
{
    public function index(): View
    {
        $halls = Hall::with('cinema')
            ->withCount(['seats', 'showtimes'])
            ->orderBy('cinema_id')
            ->orderBy('name')
            ->get();

        return view('admin.halls.index', compact('halls'));
    }

    public function create(): View
    {
        return view('admin.halls.create', [
            'hall' => new Hall(),
            'cinemas' => $this->cinemaOptions(),
        ]);
    }

    public function store(StoreHallRequest $request): RedirectResponse
    {
        $hall = DB::transaction(function () use ($request) {
            $hall = Hall::create($request->validated());

            // A hall with no seats cannot sell a ticket, so lay the seat map
            // out immediately from the capacity that was just entered.
            SeatLayout::generate($hall);

            return $hall;
        });

        return redirect()
            ->route('admin.halls.index')
            ->with('success', "\"{$hall->name}\" was created with {$hall->total_seats} seats.");
    }

    public function edit(Hall $hall): View
    {
        return view('admin.halls.edit', [
            'hall' => $hall,
            'cinemas' => $this->cinemaOptions(),
        ]);
    }

    public function update(UpdateHallRequest $request, Hall $hall): RedirectResponse
    {
        $data = $request->validated();
        $capacityChanged = (int) $data['total_seats'] !== (int) $hall->total_seats;

        // Rebuilding the seat map deletes seats, and booking_details cascade
        // off seats - so a capacity change is only safe while nothing in this
        // hall has been booked.
        if ($capacityChanged && $this->hasBookedSeats($hall)) {
            return redirect()
                ->route('admin.halls.edit', $hall)
                ->withInput()
                ->with('error', "\"{$hall->name}\" has seats that are already booked. Cancel those bookings before changing its capacity.");
        }

        DB::transaction(function () use ($hall, $data, $capacityChanged) {
            $hall->update($data);

            if ($capacityChanged) {
                $hall->seats()->delete();
                SeatLayout::generate($hall->refresh());
            }
        });

        $message = $capacityChanged
            ? "\"{$hall->name}\" was updated and its seat map rebuilt to {$hall->total_seats} seats."
            : "\"{$hall->name}\" was updated.";

        return redirect()
            ->route('admin.halls.index')
            ->with('success', $message);
    }

    public function destroy(Hall $hall): RedirectResponse
    {
        // showtimes.hall_id cascades and bookings cascade off showtimes.
        $showtimeCount = $hall->showtimes()->count();

        if ($showtimeCount > 0) {
            return redirect()
                ->route('admin.halls.index')
                ->with('error', "\"{$hall->name}\" still has {$showtimeCount} showtime(s). Remove them before deleting the hall.");
        }

        $name = $hall->name;
        $hall->delete(); // seats cascade away with it

        return redirect()
            ->route('admin.halls.index')
            ->with('success', "\"{$name}\" was deleted.");
    }

    private function hasBookedSeats(Hall $hall): bool
    {
        return BookingDetail::whereHas('seat', fn ($q) => $q->where('hall_id', $hall->id))->exists();
    }

    private function cinemaOptions()
    {
        return Cinema::orderBy('name')->get(['id', 'name']);
    }
}
