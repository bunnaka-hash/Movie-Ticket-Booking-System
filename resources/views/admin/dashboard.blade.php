@extends('layouts.admin')

@section('content')

<div>
    <h1 class="text-4xl font-bold mb-2">Welcome, {{ auth()->user()->name }} 👋</h1>
    <p class="text-gray-400 mb-8">Here's your dashboard overview</p>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

        <!-- Movies Card -->
        <a href="{{ route('admin.movies.index') }}" class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Movies</p>
                    <p class="text-4xl font-bold text-white">{{ $stats['movies'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $stats['now_showing'] }} now showing</p>
                </div>
                <i class="fas fa-film text-primary text-5xl opacity-20"></i>
            </div>
        </a>

        <!-- Cinemas Card -->
        <a href="{{ route('admin.cinemas.index') }}" class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Cinemas</p>
                    <p class="text-4xl font-bold text-white">{{ $stats['cinemas'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $stats['halls'] }} halls in total</p>
                </div>
                <i class="fas fa-building text-primary text-5xl opacity-20"></i>
            </div>
        </a>

        <!-- Showtimes Card -->
        <a href="{{ route('admin.showtimes.index') }}" class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Showtimes</p>
                    <p class="text-4xl font-bold text-white">{{ $stats['showtimes'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $stats['upcoming_showtimes'] }} upcoming</p>
                </div>
                <i class="fas fa-calendar-alt text-primary text-5xl opacity-20"></i>
            </div>
        </a>

        <!-- Bookings Card -->
        <a href="{{ route('admin.bookings.index') }}" class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Bookings</p>
                    <p class="text-4xl font-bold text-white">{{ $stats['bookings'] }}</p>
                    <p class="text-xs text-green-400 mt-2">${{ number_format($stats['revenue'], 2) }} paid</p>
                </div>
                <i class="fas fa-ticket-alt text-primary text-5xl opacity-20"></i>
            </div>
        </a>

    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-secondary p-6 rounded-xl border border-gray-800">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                Recent Bookings
            </h2>
            <div class="space-y-4">
                @forelse ($recentBookings as $booking)
                    <div class="flex items-center justify-between p-4 bg-neutral rounded-lg">
                        <div>
                            <p class="text-white font-semibold">{{ $booking->user->name ?? 'Deleted user' }}</p>
                            <p class="text-gray-400 text-sm">{{ $booking->showtime->movie->title ?? '—' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-primary font-bold">${{ number_format($booking->total_price, 2) }}</p>
                            <p class="text-gray-400 text-xs">
                                {{ \Illuminate\Support\Carbon::parse($booking->booked_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">No bookings yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800">
            <h2 class="text-xl font-bold mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.movies.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Movie
                </a>
                <a href="{{ route('admin.cinemas.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Cinema
                </a>
                <a href="{{ route('admin.showtimes.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Showtime
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block p-3 bg-tertiary hover:bg-blue-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-list mr-2"></i> View All Bookings
                </a>
            </div>
        </div>

    </div>

    <!-- Upcoming Showtimes -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 mt-6">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-xl font-bold">Upcoming Showtimes</h2>

            <a href="{{ route('admin.showtimes.index') }}"
               class="bg-primary hover:bg-red-700 px-5 py-2 rounded-lg transition">
                + Add Showtime
            </a>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="border-b border-gray-700">
                    <tr class="text-gray-400">
                        <th class="p-3">Movie</th>
                        <th class="p-3">Cinema</th>
                        <th class="p-3">Hall</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Time</th>
                        <th class="p-3">Price</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($upcomingShowtimes as $showtime)
                        <tr class="border-b border-gray-800 hover:bg-neutral transition">
                            <td class="p-3 text-white font-semibold">{{ $showtime->movie->title ?? '—' }}</td>
                            <td class="p-3 text-gray-300">{{ $showtime->hall->cinema->name ?? '—' }}</td>
                            <td class="p-3 text-gray-300">{{ $showtime->hall->name ?? '—' }}</td>
                            <td class="p-3 text-gray-300">
                                {{ \Illuminate\Support\Carbon::parse($showtime->start_time)->format('d M Y') }}
                            </td>
                            <td class="p-3 text-gray-300">
                                {{ \Illuminate\Support\Carbon::parse($showtime->start_time)->format('H:i') }}
                            </td>
                            <td class="p-3 text-primary font-semibold">${{ number_format($showtime->price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-3 text-gray-500 italic">No upcoming showtimes scheduled.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
