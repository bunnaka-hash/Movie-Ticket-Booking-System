<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Models\Cinema;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CinemaController extends Controller
{
    public function index(): View
    {
        $cinemas = Cinema::withCount('halls')
            ->withSum('halls', 'total_seats')
            ->orderBy('name')
            ->get();

        return view('admin.cinemas.index', compact('cinemas'));
    }

    public function create(): View
    {
        return view('admin.cinemas.create', ['cinema' => new Cinema()]);
    }

    public function store(StoreCinemaRequest $request): RedirectResponse
    {
        $cinema = Cinema::create($request->validated());

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "\"{$cinema->name}\" was created.");
    }

    public function edit(Cinema $cinema): View
    {
        return view('admin.cinemas.edit', compact('cinema'));
    }

    public function update(UpdateCinemaRequest $request, Cinema $cinema): RedirectResponse
    {
        $cinema->update($request->validated());

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "\"{$cinema->name}\" was updated.");
    }

    public function destroy(Cinema $cinema): RedirectResponse
    {
        // halls.cinema_id cascades, and seats/showtimes cascade off halls,
        // with bookings cascading off showtimes - deleting a cinema with
        // halls would take real bookings down with it.
        $hallCount = $cinema->halls()->count();

        if ($hallCount > 0) {
            return redirect()
                ->route('admin.cinemas.index')
                ->with('error', "\"{$cinema->name}\" still has {$hallCount} hall(s). Delete them before deleting the cinema.");
        }

        $name = $cinema->name;
        $cinema->delete();

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "\"{$name}\" was deleted.");
    }
}
