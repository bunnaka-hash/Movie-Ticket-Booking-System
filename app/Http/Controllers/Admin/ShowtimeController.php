<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShowtimeRequest;
use App\Http\Requests\UpdateShowtimeRequest;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShowtimeController extends Controller
{
    public function index(Request $request): View
    {
        $showtimes = Showtime::with(['movie', 'hall.cinema'])
            ->withCount('bookings')
            ->when($request->filled('movie_id'), fn ($q) => $q->where('movie_id', $request->movie_id))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('start_time', $request->date))
            // Upcoming shows first; past ones are still listed further down.
            ->orderByRaw('start_time < NOW()')
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $movies = Movie::orderBy('title')->get(['id', 'title']);

        return view('admin.showtimes.index', compact('showtimes', 'movies'));
    }

    public function create(): View
    {
        return view('admin.showtimes.create', [
            'showtime' => new Showtime(),
        ] + $this->formOptions());
    }

    public function store(StoreShowtimeRequest $request): RedirectResponse
    {
        $showtime = Showtime::create($request->validated());

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', $this->describe($showtime).' was scheduled.');
    }

    public function edit(Showtime $showtime): View
    {
        return view('admin.showtimes.edit', [
            'showtime' => $showtime,
        ] + $this->formOptions());
    }

    public function update(UpdateShowtimeRequest $request, Showtime $showtime): RedirectResponse
    {
        $data = $request->validated();

        // Booked seats belong to the hall the seats live in, so moving a
        // booked showtime to another hall would point tickets at seats that
        // are not in the room the customer is walking into.
        if ((int) $data['hall_id'] !== (int) $showtime->hall_id && $showtime->bookings()->exists()) {
            return redirect()
                ->route('admin.showtimes.edit', $showtime)
                ->withInput()
                ->with('error', 'This showtime already has bookings, so it cannot be moved to a different hall.');
        }

        $showtime->update($data);

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', $this->describe($showtime).' was updated.');
    }

    public function destroy(Showtime $showtime): RedirectResponse
    {
        // bookings.showtime_id cascades, and booking_details cascade off that.
        $bookingCount = $showtime->bookings()->count();

        if ($bookingCount > 0) {
            return redirect()
                ->route('admin.showtimes.index')
                ->with('error', $this->describe($showtime)." has {$bookingCount} booking(s). Cancel them before deleting the showtime.");
        }

        $label = $this->describe($showtime);
        $showtime->delete();

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', $label.' was deleted.');
    }

    private function formOptions(): array
    {
        return [
            'movies' => Movie::orderBy('title')->get(['id', 'title', 'duration']),
            'halls' => Hall::with('cinema')->orderBy('cinema_id')->orderBy('name')->get(),
        ];
    }

    private function describe(Showtime $showtime): string
    {
        $showtime->loadMissing('movie');

        return sprintf(
            '"%s" on %s',
            $showtime->movie->title ?? 'Showtime',
            \Illuminate\Support\Carbon::parse($showtime->start_time)->format('M d, H:i')
        );
    }
}
