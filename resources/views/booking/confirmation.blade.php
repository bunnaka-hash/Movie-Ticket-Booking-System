@extends('layouts.app')

@section('title', 'Booking ' . $booking->booking_code . ' - Cinema Premium')

@section('content')

@php
    $start = \Illuminate\Support\Carbon::parse($booking->showtime->start_time);
    $seatLabels = $booking->bookingDetails->map(fn ($d) => $d->seat?->row_name . $d->seat?->seat_number)->filter();
    $badge = match ($booking->booking_status) {
        'paid' => 'bg-green-900 text-green-200',
        'pending' => 'bg-yellow-900 text-yellow-200',
        default => 'bg-red-900 text-red-200',
    };
@endphp

<section class="bg-neutral py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <div class="w-16 h-16 rounded-full bg-green-900/50 text-green-300 flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Booking Confirmed</h1>
            <p class="text-gray-400">Show this code at the counter to collect your tickets.</p>
        </div>

        <!-- Ticket -->
        <div class="bg-secondary rounded-xl overflow-hidden border border-gray-800">
            <div class="bg-primary px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-xs uppercase tracking-widest">Booking Code</p>
                    <p class="text-white text-2xl font-extrabold tracking-wider">{{ $booking->booking_code }}</p>
                </div>
                <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">{{ ucfirst($booking->booking_status) }}</span>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $booking->showtime->movie->title ?? '—' }}</h2>
                    <p class="text-gray-400 text-sm mt-1">
                        {{ $booking->showtime->hall->cinema->name ?? '' }} &middot; {{ $booking->showtime->hall->name ?? '' }}
                    </p>
                </div>

                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm border-t border-gray-700 pt-6">
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-1">Date</dt>
                        <dd class="text-white font-semibold">{{ $start->format('D M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-1">Time</dt>
                        <dd class="text-white font-semibold">{{ $start->format('H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-1">Seats</dt>
                        <dd class="text-white font-semibold">{{ $seatLabels->implode(', ') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-1">Total</dt>
                        <dd class="text-primary font-bold">${{ number_format($booking->total_price, 2) }}</dd>
                    </div>
                </dl>

                <div class="border-t border-gray-700 pt-6 text-sm text-gray-400">
                    <p>
                        Payment:
                        <span class="text-white">{{ $booking->payment_method ? strtoupper($booking->payment_method) : 'At the counter' }}</span>
                    </p>
                    <p class="mt-1">Booked on {{ \Illuminate\Support\Carbon::parse($booking->booked_at)->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 mt-8 justify-center">
            <a href="{{ route('bookings.index') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded font-bold transition">
                <i class="fas fa-ticket-alt mr-2"></i> My Tickets
            </a>
            <a href="{{ route('movies.index') }}" class="bg-secondary hover:bg-gray-700 text-gray-200 px-6 py-3 rounded font-bold border border-gray-700 transition">
                Book Another Movie
            </a>
        </div>

    </div>
</section>

@endsection
