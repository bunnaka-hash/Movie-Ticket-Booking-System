<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'movies' => Movie::count(),
            'now_showing' => Movie::where('status', 'now_showing')->count(),
            'cinemas' => Cinema::count(),
            'halls' => Hall::count(),
            'showtimes' => Showtime::count(),
            'upcoming_showtimes' => Showtime::where('start_time', '>=', now())->count(),
            'bookings' => Booking::count(),
            'revenue' => Booking::where('booking_status', 'paid')->sum('total_price'),
        ];

        $recentBookings = Booking::with(['user', 'showtime.movie'])
            ->latest('booked_at')
            ->take(5)
            ->get();

        $upcomingShowtimes = Showtime::with(['movie', 'hall.cinema'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'upcomingShowtimes'));
    }
}
