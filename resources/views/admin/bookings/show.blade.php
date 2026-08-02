@extends('layouts.admin')

@section('content')

@php
    $badge = match ($booking->booking_status) {
        'paid' => 'bg-green-900 text-green-200',
        'pending' => 'bg-yellow-900 text-yellow-200',
        default => 'bg-red-900 text-red-200',
    };
@endphp

<div>
    <div class="mb-8">
        <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
        </a>
        <div class="flex items-center gap-4 mt-3">
            <h1 class="text-4xl font-bold">{{ $booking->booking_code }}</h1>
            <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">{{ ucfirst($booking->booking_status) }}</span>
            @if ($booking->checked_in_at)
                <span class="bg-blue-900 text-blue-200 px-3 py-1 rounded text-xs font-semibold">
                    <i class="fas fa-check mr-1"></i>Checked in
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-secondary p-6 rounded-xl border border-gray-800">
                <h2 class="text-xl font-bold mb-4">Showtime</h2>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-400">Movie</dt><dd class="text-white font-semibold">{{ $booking->showtime->movie->title ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400">Cinema</dt><dd class="text-white">{{ $booking->showtime->hall->cinema->name ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400">Hall</dt><dd class="text-white">{{ $booking->showtime->hall->name ?? '—' }}</dd></div>
                    <div>
                        <dt class="text-gray-400">Starts</dt>
                        <dd class="text-white">
                            {{ $booking->showtime ? \Illuminate\Support\Carbon::parse($booking->showtime->start_time)->format('D M d, Y H:i') : '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-secondary p-6 rounded-xl border border-gray-800">
                <h2 class="text-xl font-bold mb-4">Seats ({{ $booking->bookingDetails->count() }})</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-700 text-gray-400">
                            <th class="text-left py-2">Seat</th>
                            <th class="text-left py-2">Type</th>
                            <th class="text-right py-2">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->bookingDetails as $detail)
                            <tr class="border-b border-gray-800">
                                <td class="py-2 text-white font-semibold">{{ $detail->seat?->row_name }}{{ $detail->seat?->seat_number }}</td>
                                <td class="py-2 text-gray-300">{{ ucfirst($detail->seat?->seat_type ?? '—') }}</td>
                                <td class="py-2 text-right text-gray-300">${{ number_format($detail->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="pt-3 text-gray-400">Total</td>
                            <td class="pt-3 text-right text-primary font-bold">${{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-secondary p-6 rounded-xl border border-gray-800">
                <h2 class="text-xl font-bold mb-4">Customer</h2>
                <p class="text-white font-semibold">{{ $booking->user->name ?? 'Deleted user' }}</p>
                <p class="text-gray-400 text-sm">{{ $booking->user->email ?? '' }}</p>
                <p class="text-gray-400 text-sm">{{ $booking->user->phone ?? '' }}</p>
            </div>

            <div class="bg-secondary p-6 rounded-xl border border-gray-800 text-sm space-y-2">
                <h2 class="text-xl font-bold mb-4">Payment</h2>
                <p class="text-gray-400">Method: <span class="text-white">{{ $booking->payment_method ? strtoupper($booking->payment_method) : '—' }}</span></p>
                <p class="text-gray-400">Booked: <span class="text-white">{{ \Illuminate\Support\Carbon::parse($booking->booked_at)->format('M d, Y H:i') }}</span></p>
                @if ($booking->checked_in_at)
                    <p class="text-gray-400">Checked in: <span class="text-white">{{ \Illuminate\Support\Carbon::parse($booking->checked_in_at)->format('M d, Y H:i') }}</span></p>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.edit', $booking) }}" class="flex-1 py-3 bg-primary hover:bg-red-700 text-white text-center rounded-lg font-semibold transition">Edit</a>

                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="flex-1"
                      onsubmit="return confirm('Delete booking {{ $booking->booking_code }}? Its seats will be released.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-red-900 hover:bg-red-800 text-white rounded-lg font-semibold transition">Delete</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
