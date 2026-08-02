<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->withCount('showtimes')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.movies.index', compact('movies'));
    }

    public function create(): View
    {
        return view('admin.movies.create', ['movie' => new Movie()]);
    }

    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['poster'] = $this->resolvePoster($request, $data['poster'] ?? null);

        $movie = Movie::create($data);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "\"{$movie->title}\" was created.");
    }

    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $data = $request->validated();
        $data['poster'] = $this->resolvePoster($request, $data['poster'] ?? null, $movie);

        $movie->update($data);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "\"{$movie->title}\" was updated.");
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        // showtimes.movie_id cascades on delete, and bookings cascade off
        // showtimes - deleting a scheduled movie would silently wipe out
        // real bookings, so block it and let the admin clear the schedule.
        $showtimeCount = $movie->showtimes()->count();

        if ($showtimeCount > 0) {
            return redirect()
                ->route('admin.movies.index')
                ->with('error', "\"{$movie->title}\" still has {$showtimeCount} showtime(s). Remove them before deleting the movie.");
        }

        $title = $movie->title;
        $this->deleteUploadedPoster($movie->poster);
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "\"{$title}\" was deleted.");
    }

    /**
     * An uploaded file wins; otherwise keep whatever string the form supplied
     * (a filename or an external URL), falling back to the existing poster.
     */
    private function resolvePoster(Request $request, ?string $poster, ?Movie $movie = null): ?string
    {
        if ($request->hasFile('poster_file')) {
            $this->deleteUploadedPoster($movie?->poster);

            return $request->file('poster_file')->store('posters', 'public');
        }

        return $poster ?? $movie?->poster;
    }

    /**
     * Only remove files we actually uploaded - seeded posters are bare
     * filenames and external posters are URLs; neither lives on our disk.
     */
    private function deleteUploadedPoster(?string $poster): void
    {
        if ($poster && str_starts_with($poster, 'posters/')) {
            Storage::disk('public')->delete($poster);
        }
    }
}
