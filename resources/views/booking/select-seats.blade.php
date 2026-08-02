@extends('layouts.app')

@section('title', 'Select Seats - Cinema Premium')

@section('content')

@php
    $start = \Illuminate\Support\Carbon::parse($showtime->start_time);
@endphp

<section class="bg-gradient-to-r from-neutral to-secondary py-10 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('movies.show', $showtime->movie_id) }}" class="text-primary hover:text-red-400 transition text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to {{ $showtime->movie->title ?? 'movie' }}
        </a>
        <h1 class="text-4xl font-bold text-white mt-3">Select Your Seats</h1>
        <p class="text-gray-400 mt-2">
            {{ $showtime->movie->title ?? '' }} &middot;
            {{ $showtime->hall->cinema->name ?? '' }} / {{ $showtime->hall->name ?? '' }} &middot;
            {{ $start->format('D M d, H:i') }}
        </p>
    </div>
</section>

<section class="bg-neutral py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @error('seat_ids')
            <div class="bg-red-900/40 border border-red-700 text-red-100 px-4 py-3 rounded-lg mb-6" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Seat map -->
                <div class="lg:col-span-2">
                    <div class="bg-secondary p-6 rounded-lg">
                        <div class="text-center mb-8">
                            <div class="h-2 bg-gradient-to-r from-transparent via-primary to-transparent rounded-full mb-2"></div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest">Screen</p>
                        </div>

                        <div class="space-y-2 overflow-x-auto">
                            @foreach ($seats->groupBy('row_name') as $rowName => $rowSeats)
                                <div class="flex items-center gap-2 justify-center">
                                    <span class="w-6 text-center text-sm text-gray-400">{{ $rowName }}</span>

                                    @foreach ($rowSeats as $seat)
                                        @php $taken = $takenSeatIds->contains($seat->id); @endphp
                                        <label class="relative">
                                            <input type="checkbox" name="seat_ids[]" value="{{ $seat->id }}"
                                                   data-price="{{ $showtime->price }}"
                                                   data-label="{{ $seat->row_name }}{{ $seat->seat_number }}"
                                                   class="peer sr-only seat-checkbox"
                                                   @disabled($taken)
                                                   @checked(in_array($seat->id, old('seat_ids', [])))>
                                            <span @class([
                                                'block w-8 h-8 leading-8 text-center text-xs rounded border transition',
                                                'bg-gray-800 text-gray-600 border-gray-800 cursor-not-allowed' => $taken,
                                                'cursor-pointer border-gray-700 hover:border-primary peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary' => ! $taken,
                                                'bg-yellow-900/40 text-yellow-200' => ! $taken && $seat->seat_type === 'vip',
                                                'bg-neutral text-gray-300' => ! $taken && $seat->seat_type !== 'vip',
                                            ])>{{ $seat->seat_number }}</span>
                                        </label>
                                    @endforeach

                                    <span class="w-6 text-center text-sm text-gray-400">{{ $rowName }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-700 flex flex-wrap gap-6 justify-center text-sm text-gray-400">
                            <div class="flex items-center gap-2"><span class="w-5 h-5 rounded bg-neutral border border-gray-700"></span> Available</div>
                            <div class="flex items-center gap-2"><span class="w-5 h-5 rounded bg-yellow-900/40 border border-gray-700"></span> VIP</div>
                            <div class="flex items-center gap-2"><span class="w-5 h-5 rounded bg-primary"></span> Selected</div>
                            <div class="flex items-center gap-2"><span class="w-5 h-5 rounded bg-gray-800"></span> Taken</div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <aside class="space-y-4">
                    <div class="bg-secondary p-6 rounded-lg">
                        <h3 class="text-white font-bold mb-4">{{ $showtime->movie->title ?? '' }}</h3>
                        <p class="text-gray-400 text-sm mb-1">
                            <i class="fas fa-building text-primary mr-2"></i>{{ $showtime->hall->cinema->name ?? '' }}
                        </p>
                        <p class="text-gray-400 text-sm mb-1">
                            <i class="fas fa-door-open text-primary mr-2"></i>{{ $showtime->hall->name ?? '' }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            <i class="fas fa-clock text-primary mr-2"></i>{{ $start->format('D M d, Y H:i') }}
                        </p>
                    </div>

                    <div class="bg-secondary p-6 rounded-lg">
                        <p class="text-xs text-gray-400 uppercase mb-2">Selected Seats</p>
                        <div id="selection-list" class="min-h-[48px] text-sm text-gray-400 italic">No seats selected yet</div>
                    </div>

                    <div class="bg-secondary p-6 rounded-lg">
                        <label for="payment_method" class="block text-xs text-gray-400 uppercase mb-2">Payment Method</label>
                        <select id="payment_method" name="payment_method"
                                class="w-full bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none mb-4">
                            <option value="">Pay at the counter</option>
                            @foreach (['cash' => 'Cash', 'card' => 'Card', 'aba' => 'ABA', 'acleda' => 'ACLEDA', 'wing' => 'Wing'] as $key => $label)
                                <option value="{{ $key }}" @selected(old('payment_method') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs text-gray-400 uppercase">
                                Total (<span id="seat-count">0</span> &times; ${{ number_format($showtime->price, 2) }})
                            </span>
                            <span id="total-price" class="text-2xl font-extrabold text-primary">$0.00</span>
                        </div>

                        <button type="submit" id="continue-btn" disabled
                                class="w-full bg-primary hover:bg-red-700 text-white py-3 rounded font-bold transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-ticket-alt mr-2"></i> Confirm Booking
                        </button>
                    </div>
                </aside>

            </div>
        </form>
    </div>
</section>

<script>
    (function () {
        const boxes = document.querySelectorAll('.seat-checkbox');
        const list = document.getElementById('selection-list');
        const countEl = document.getElementById('seat-count');
        const totalEl = document.getElementById('total-price');
        const button = document.getElementById('continue-btn');

        function update() {
            const chosen = Array.from(document.querySelectorAll('.seat-checkbox:checked'));
            const total = chosen.reduce((sum, box) => sum + parseFloat(box.dataset.price), 0);

            countEl.textContent = chosen.length;
            totalEl.textContent = '$' + total.toFixed(2);
            button.disabled = chosen.length === 0;

            if (chosen.length === 0) {
                list.innerHTML = '<span class="text-gray-400 italic">No seats selected yet</span>';
                return;
            }

            list.innerHTML = chosen.map(box =>
                '<span class="inline-block bg-primary text-white px-2 py-1 rounded mr-2 mb-2 text-xs">' + box.dataset.label + '</span>'
            ).join('');
        }

        boxes.forEach(box => box.addEventListener('change', update));
        update();
    })();
</script>

@endsection
