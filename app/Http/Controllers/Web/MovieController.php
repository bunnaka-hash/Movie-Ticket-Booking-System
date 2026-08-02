<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $movies = Movie::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%"));
            })
            ->when($request->filled('genre'), fn ($q) => $q->where('genre', $request->genre))
            ->when($request->filled('language'), fn ($q) => $q->where('language', $request->language))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('movies.index', [
            'movies' => $movies,
            'genres' => Movie::select('genre')->distinct()->orderBy('genre')->pluck('genre'),
            'languages' => Movie::select('language')->distinct()->orderBy('language')->pluck('language'),
        ]);
    }

    public function show(Movie $movie, Request $request): View
    {
        // Only upcoming screenings can be booked.
        $showtimes = Showtime::with('hall.cinema')
            ->where('movie_id', $movie->id)
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();

        // Only offer dates that actually have screenings.
        $dates = $showtimes
            ->map(fn ($showtime) => Carbon::parse($showtime->start_time)->toDateString())
            ->unique()
            ->values();

        $selectedDate = $request->filled('date') && $dates->contains($request->date)
            ? $request->date
            : $dates->first();

        // Group the chosen day's screenings by cinema so each venue lists its times.
        $showtimesByCinema = $showtimes
            ->filter(fn ($showtime) => Carbon::parse($showtime->start_time)->toDateString() === $selectedDate)
            ->groupBy(fn ($showtime) => $showtime->hall->cinema->name ?? 'Unknown cinema');

        return view('movies.show', compact('movie', 'dates', 'selectedDate', 'showtimesByCinema'));
    }
}
