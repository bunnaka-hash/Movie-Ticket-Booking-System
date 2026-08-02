@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Bookings Management</h1>
            <p class="text-gray-400 mt-2">{{ $bookings->total() }} ticket bookings</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> New Booking
        </a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by booking code or customer..."
               class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <select name="status" class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option value="">All Status</option>
            @foreach (['paid' => 'Paid', 'pending' => 'Pending', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-2 rounded font-semibold transition">
            Filter
        </button>
    </form>

    <!-- Bookings Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Booking Code</th>
                    <th class="text-left py-4 px-4 text-gray-400">Customer</th>
                    <th class="text-left py-4 px-4 text-gray-400">Movie</th>
                    <th class="text-left py-4 px-4 text-gray-400">Date & Time</th>
                    <th class="text-left py-4 px-4 text-gray-400">Seats</th>
                    <th class="text-left py-4 px-4 text-gray-400">Amount</th>
                    <th class="text-left py-4 px-4 text-gray-400">Status</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr class="border-b border-gray-800 hover:bg-neutral transition">
                        <td class="py-4 px-4 text-white font-semibold">
                            {{ $booking->booking_code }}
                            @if ($booking->checked_in_at)
                                <span class="block text-xs text-green-400 mt-1">
                                    <i class="fas fa-check mr-1"></i>Checked in
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-gray-300">{{ $booking->user->name ?? 'Deleted user' }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $booking->showtime->movie->title ?? '—' }}</td>
                        <td class="py-4 px-4 text-gray-300">
                            {{ $booking->showtime ? \Illuminate\Support\Carbon::parse($booking->showtime->start_time)->format('M d, H:i') : '—' }}
                        </td>
                        <td class="py-4 px-4 text-gray-300">
                            {{ $booking->bookingDetails->map(fn ($detail) => $detail->seat?->row_name . $detail->seat?->seat_number)->filter()->implode(', ') ?: '—' }}
                        </td>
                        <td class="py-4 px-4 text-primary font-semibold">${{ number_format($booking->total_price, 2) }}</td>
                        <td class="py-4 px-4">
                            @php
                                $badge = match ($booking->booking_status) {
                                    'paid' => 'bg-green-900 text-green-200',
                                    'pending' => 'bg-yellow-900 text-yellow-200',
                                    default => 'bg-red-900 text-red-200',
                                };
                            @endphp
                            <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-primary hover:text-red-400 mr-3">View</a>
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-primary hover:text-red-400 mr-3">Edit</a>

                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="inline"
                                  onsubmit="return confirm('Delete booking {{ $booking->booking_code }}? Its seats will be released.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 px-4 text-center text-gray-500 italic">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>

@endsection
