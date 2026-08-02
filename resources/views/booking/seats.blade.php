@extends('layouts.app')

@section('title', 'Select Seats - Cinema Premium')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-neutral to-secondary py-12 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="javascript:history.back()" class="text-primary hover:text-red-400 transition text-lg">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-4xl font-bold text-white">Select Your Seats</h1>
        </div>
        <p class="text-gray-400">Choose your preferred seats</p>
    </div>
</section>

<!-- Seats Selection -->
<section class="bg-neutral py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Seat Map -->
            <div class="lg:col-span-2">
                <!-- Screen -->
                <div class="bg-gradient-to-b from-transparent to-tertiary p-8 rounded-t-3xl mb-8 text-center">
                    <p class="text-gray-300 font-semibold">SCREEN</p>
                </div>

                <!-- Seat Grid -->
                <div class="bg-secondary p-8 rounded-lg">
                    <div class="space-y-4">
                        @for ($row = 1; $row <= 8; $row++)
                            <div class="flex justify-between items-center gap-2">
                                <span class="text-gray-400 font-bold w-8 text-center">{{ chr(64 + $row) }}</span>
                                <div class="flex gap-2 flex-wrap justify-center flex-1">
                                    @for ($seat = 1; $seat <= 12; $seat++)
                                        <button class="seat-btn w-8 h-8 bg-neutral rounded border border-gray-700 text-gray-400 text-xs hover:border-primary hover:text-primary transition cursor-pointer" data-seat="{{ chr(64 + $row) }}{{ $seat }}">
                                            {{ $seat }}
                                        </button>
                                    @endfor
                                </div>
                                <span class="text-gray-400 font-bold w-8 text-center">{{ chr(64 + $row) }}</span>
                            </div>
                        @endfor
                    </div>

                    <!-- Legend -->
                    <div class="flex justify-center gap-8 mt-12 pt-8 border-t border-gray-700">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-neutral rounded border border-gray-700"></div>
                            <span class="text-gray-400 text-sm">Available</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-primary rounded border border-primary"></div>
                            <span class="text-gray-400 text-sm">Selected</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gray-600 rounded border border-gray-600"></div>
                            <span class="text-gray-400 text-sm">Occupied</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <!-- Movie Info -->
                    <div class="bg-secondary p-6 rounded-lg mb-6">
                        <h3 class="text-white font-bold mb-4">Booking Summary</h3>
                        <div class="space-y-3 mb-4">
                            <div>
                                <p class="text-gray-400 text-xs mb-1">MOVIE</p>
                                <p class="text-white font-semibold">{{ request('movie') ?? 'Movie Title' }}</p>
                            </div>
                            <div class="border-t border-gray-700 pt-3">
                                <p class="text-gray-400 text-xs mb-1">FORMAT & TIME</p>
                                <p class="text-white font-semibold">{{ request('format', '2D') }} • {{ request('time', '14:00') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Seats -->
                    <div class="bg-secondary p-6 rounded-lg mb-6">
                        <h3 class="text-white font-bold mb-4">Selected Seats</h3>
                        <div id="selectedSeats" class="flex flex-wrap gap-2 mb-4 min-h-8">
                            <p class="text-gray-400 text-sm">No seats selected</p>
                        </div>
                        <div class="border-t border-gray-700 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Subtotal:</span>
                                <span class="text-white font-semibold">$0.00</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-400">Tax:</span>
                                <span class="text-white font-semibold">$0.00</span>
                            </div>
                            <div class="flex justify-between mb-4 pb-4 border-b border-gray-700">
                                <span class="text-gray-400">Convenience Fee:</span>
                                <span class="text-white font-semibold">$0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white font-bold">TOTAL:</span>
                                <span class="text-3xl font-bold text-primary">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button id="continueBtn" class="w-full bg-gray-600 text-white py-3 rounded font-bold transition cursor-not-allowed" disabled>
                        Select Seats to Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatBtns = document.querySelectorAll('.seat-btn');
    const selectedSeatsDiv = document.getElementById('selectedSeats');
    const continueBtn = document.getElementById('continueBtn');
    let selectedSeats = [];
    const pricePerSeat = 12.50;

    seatBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const seatName = this.getAttribute('data-seat');
            
            if (this.classList.contains('bg-primary')) {
                // Deselect
                this.classList.remove('bg-primary', 'border-primary', 'text-white');
                this.classList.add('bg-neutral', 'border-gray-700', 'text-gray-400');
                selectedSeats = selectedSeats.filter(s => s !== seatName);
            } else {
                // Select
                this.classList.remove('bg-neutral', 'border-gray-700', 'text-gray-400');
                this.classList.add('bg-primary', 'border-primary', 'text-white');
                selectedSeats.push(seatName);
            }

            updateSummary();
        });
    });

    function updateSummary() {
        if (selectedSeats.length === 0) {
            selectedSeatsDiv.innerHTML = '<p class="text-gray-400 text-sm">No seats selected</p>';
            continueBtn.setAttribute('disabled', 'disabled');
            continueBtn.classList.remove('bg-primary', 'hover:bg-red-700', 'cursor-pointer');
            continueBtn.classList.add('bg-gray-600', 'cursor-not-allowed');
            continueBtn.textContent = 'Select Seats to Continue';
        } else {
            selectedSeatsDiv.innerHTML = selectedSeats.map(seat => 
                `<span class="bg-primary text-white px-3 py-1 rounded text-sm font-semibold">${seat}</span>`
            ).join('');

            const total = selectedSeats.length * pricePerSeat;
            const tax = total * 0.08;
            const fee = 1.50 * selectedSeats.length;
            const grandTotal = total + tax + fee;

            // Update pricing (Note: This is a simplified version, in production you'd update the actual elements)
            continueBtn.removeAttribute('disabled');
            continueBtn.classList.remove('bg-gray-600', 'cursor-not-allowed');
            continueBtn.classList.add('bg-primary', 'hover:bg-red-700', 'cursor-pointer');
            continueBtn.textContent = `Continue to Checkout - ${selectedSeats.length} Seat${selectedSeats.length > 1 ? 's' : ''}`;
        }
    }
});
</script>
@endsection
