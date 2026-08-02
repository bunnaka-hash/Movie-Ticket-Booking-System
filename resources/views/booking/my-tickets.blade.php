@extends('layouts.app')

@section('title', 'My Tickets - Cinema Premium')

@section('content')

<section class="bg-gradient-to-r from-neutral to-secondary py-12 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-white mb-2">
            <i class="fas fa-ticket-alt text-primary mr-3"></i>My Tickets
        </h1>
        <p class="text-gray-400">{{ $bookings->total() }} booking(s)</p>
    </div>
</section>

<section class="bg-neutral py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

        @forelse ($bookings as $booking)
            @php
                $start = \Illuminate\Support\Carbon::parse($booking->showtime->start_time);
                $seatLabels = $booking->bookingDetails->map(fn ($d) => $d->seat?->row_name . $d->seat?->seat_number)->filter();
                $badge = match ($booking->booking_status) {
                    'paid' => 'bg-green-900 text-green-200',
                    'pending' => 'bg-yellow-900 text-yellow-200',
                    default => 'bg-red-900 text-red-200',
                };
            @endphp

            <div class="bg-secondary p-6 rounded-lg border border-gray-800 flex flex-col md:flex-row md:items-center gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-xl font-bold text-white">{{ $booking->showtime->movie->title ?? '—' }}</h2>
                        <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">{{ ucfirst($booking->booking_status) }}</span>
                        @if ($start->isPast())
                            <span class="bg-gray-800 text-gray-400 px-3 py-1 rounded text-xs">Finished</span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">
                        {{ $booking->showtime->hall->cinema->name ?? '' }} &middot;
                        {{ $booking->showtime->hall->name ?? '' }} &middot;
                        {{ $start->format('D M d, Y H:i') }}
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                        Seats: <span class="text-white">{{ $seatLabels->implode(', ') ?: '—' }}</span>
                        &middot; Code: <span class="text-white font-mono">{{ $booking->booking_code }}</span>
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-2xl font-bold text-primary mb-3">${{ number_format($booking->total_price, 2) }}</p>
                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('bookings.show', $booking) }}"
                           class="px-4 py-2 bg-neutral hover:bg-gray-700 text-gray-200 rounded text-sm border border-gray-700 transition">
                            View
                        </a>

                        @if ($booking->booking_status !== 'cancelled' && ! $start->isPast())
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                                  onsubmit="return confirm('Cancel booking {{ $booking->booking_code }}? Your seats will be released.')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-red-900 hover:bg-red-800 text-white rounded text-sm transition">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-secondary p-12 rounded-lg text-center">
                <i class="fas fa-ticket-alt text-5xl text-gray-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-300 mb-2">No tickets yet</h3>
                <p class="text-gray-500 mb-6">Browse what's showing and book your first film.</p>
                <a href="{{ route('movies.index') }}" class="inline-block bg-primary hover:bg-red-700 text-white px-6 py-3 rounded font-bold transition">
                    Browse Movies
                </a>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</section>

@endsection
