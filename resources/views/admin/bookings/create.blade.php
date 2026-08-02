@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
        </a>
        <h1 class="text-4xl font-bold mt-3">New Booking</h1>
        <p class="text-gray-400 mt-2">Sell tickets at the counter on behalf of a customer</p>
    </div>

    <!-- Step 1: pick the showtime (reloads the page with that hall's seat map) -->
    <form method="GET" action="{{ route('admin.bookings.create') }}" class="bg-secondary p-6 rounded-xl border border-gray-800 mb-6">
        <label for="showtime_id" class="block text-sm text-gray-400 mb-2">1. Showtime <span class="text-primary">*</span></label>
        <div class="flex gap-3">
            <select id="showtime_id" name="showtime_id" required
                    class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
                <option value="">Select an upcoming showtime</option>
                @foreach ($showtimes as $option)
                    <option value="{{ $option->id }}" @selected($showtime && $showtime->id === $option->id)>
                        {{ \Illuminate\Support\Carbon::parse($option->start_time)->format('D M d, H:i') }} —
                        {{ $option->movie->title ?? '?' }} —
                        {{ $option->hall->cinema->name ?? '?' }} / {{ $option->hall->name ?? '?' }}
                        (${{ number_format($option->price, 2) }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-tertiary hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold transition">
                Load Seats
            </button>
        </div>
        @if ($showtimes->isEmpty())
            <p class="text-yellow-400 text-xs mt-2">There are no upcoming showtimes to book.</p>
        @endif
    </form>

    @if ($showtime)
        <form method="POST" action="{{ route('admin.bookings.store') }}" class="bg-secondary p-6 rounded-xl border border-gray-800">
            @csrf
            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label for="user_id" class="block text-sm text-gray-400 mb-2">2. Customer <span class="text-primary">*</span></label>
                    <select id="user_id" name="user_id" required
                            class="w-full bg-neutral text-white px-4 py-2 rounded border @error('user_id') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected((int) old('user_id') === $customer->id)>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="booking_status" class="block text-sm text-gray-400 mb-2">Status <span class="text-primary">*</span></label>
                    <select id="booking_status" name="booking_status" required
                            class="w-full bg-neutral text-white px-4 py-2 rounded border @error('booking_status') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
                        @foreach (['paid' => 'Paid', 'pending' => 'Pending', 'cancelled' => 'Cancelled'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('booking_status', 'paid') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('booking_status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-sm text-gray-400 mb-2">Payment Method</label>
                    <select id="payment_method" name="payment_method"
                            class="w-full bg-neutral text-white px-4 py-2 rounded border @error('payment_method') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
                        <option value="">— none —</option>
                        @foreach (['cash' => 'Cash', 'card' => 'Card', 'aba' => 'ABA', 'acleda' => 'ACLEDA', 'wing' => 'Wing'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('payment_method') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('payment_method') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4 flex items-baseline justify-between">
                <div>
                    <p class="text-sm text-gray-400">3. Seats <span class="text-primary">*</span></p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $showtime->hall->name ?? '' }} — ${{ number_format($showtime->price, 2) }} per seat.
                        Greyed seats are already booked.
                    </p>
                </div>
                <p class="text-sm text-gray-400">
                    Selected: <span id="seat-count" class="text-white font-semibold">0</span> ·
                    Total: <span id="seat-total" class="text-primary font-bold">$0.00</span>
                </p>
            </div>

            @error('seat_ids') <p class="text-red-400 text-sm mb-3">{{ $message }}</p> @enderror

            <div class="bg-neutral p-4 rounded-lg space-y-2 overflow-x-auto">
                @foreach ($seats->groupBy('row_name') as $rowName => $rowSeats)
                    <div class="flex items-center gap-2">
                        <span class="w-6 text-center text-sm text-gray-400">{{ $rowName }}</span>
                        @foreach ($rowSeats as $seat)
                            @php $taken = $takenSeatIds->contains($seat->id); @endphp
                            <label class="relative">
                                <input type="checkbox" name="seat_ids[]" value="{{ $seat->id }}"
                                       class="peer sr-only seat-checkbox" @disabled($taken)
                                       @checked(in_array($seat->id, old('seat_ids', []))) >
                                <span @class([
                                    'block w-8 h-8 leading-8 text-center text-xs rounded border transition',
                                    'bg-gray-800 text-gray-600 border-gray-800 cursor-not-allowed' => $taken,
                                    'cursor-pointer border-gray-700 hover:border-primary peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary' => ! $taken,
                                    'bg-yellow-900/40 text-yellow-200' => ! $taken && $seat->seat_type === 'vip',
                                    'bg-neutral text-gray-300' => ! $taken && $seat->seat_type !== 'vip',
                                ])>{{ $seat->seat_number }}</span>
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-ticket-alt mr-2"></i> Create Booking
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>

        <script>
            (function () {
                const price = {{ (float) $showtime->price }};
                const boxes = document.querySelectorAll('.seat-checkbox');
                const countEl = document.getElementById('seat-count');
                const totalEl = document.getElementById('seat-total');

                function update() {
                    const n = document.querySelectorAll('.seat-checkbox:checked').length;
                    countEl.textContent = n;
                    totalEl.textContent = '$' + (n * price).toFixed(2);
                }

                boxes.forEach(b => b.addEventListener('change', update));
                update();
            })();
        </script>
    @endif
</div>

@endsection
