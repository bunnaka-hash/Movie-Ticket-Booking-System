@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Booking
        </a>
        <h1 class="text-4xl font-bold mt-3">Edit {{ $booking->booking_code }}</h1>
        <p class="text-gray-400 mt-2">
            {{ $booking->user->name ?? 'Deleted user' }} &middot;
            {{ $booking->showtime->movie->title ?? '—' }} &middot;
            {{ $booking->bookingDetails->map(fn ($d) => $d->seat?->row_name . $d->seat?->seat_number)->filter()->implode(', ') }}
        </p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <p class="text-gray-500 text-xs mb-6">
            Seats are fixed once sold — delete this booking and create a new one to change them.
        </p>

        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="booking_status" class="block text-sm text-gray-400 mb-2">Status <span class="text-primary">*</span></label>
                    <select id="booking_status" name="booking_status" required
                            class="w-full bg-neutral text-white px-4 py-2 rounded border @error('booking_status') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
                        @foreach (['pending' => 'Pending', 'paid' => 'Paid', 'cancelled' => 'Cancelled'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('booking_status', $booking->booking_status) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Cancelling releases the seats for resale.</p>
                    @error('booking_status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-sm text-gray-400 mb-2">Payment Method</label>
                    <select id="payment_method" name="payment_method"
                            class="w-full bg-neutral text-white px-4 py-2 rounded border @error('payment_method') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
                        <option value="">— none —</option>
                        @foreach (['cash' => 'Cash', 'card' => 'Card', 'aba' => 'ABA', 'acleda' => 'ACLEDA', 'wing' => 'Wing'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('payment_method', $booking->payment_method) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-3">
                        <input type="hidden" name="checked_in" value="0">
                        <input type="checkbox" name="checked_in" value="1"
                               @checked(old('checked_in', $booking->checked_in_at ? 1 : 0))
                               class="rounded border-gray-700 bg-neutral text-primary focus:ring-primary">
                        <span class="text-sm text-gray-300">Checked in at the door</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
