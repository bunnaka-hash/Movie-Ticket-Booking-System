@extends('layouts.app')

@section('title', 'Select Showtime - Cinema Premium')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-neutral to-secondary py-12 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="javascript:history.back()" class="text-primary hover:text-red-400 transition text-lg">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-4xl font-bold text-white">Select Showtime</h1>
        </div>
        <p class="text-gray-400">Choose your preferred date and time</p>
    </div>
</section>

<!-- Showtime Selection -->
<section class="bg-neutral py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Side - Movie & Cinema Info -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <!-- Movie Info -->
                    <div class="bg-secondary p-6 rounded-lg mb-8">
                        <h3 class="text-white font-bold mb-4">Movie</h3>
                        <h2 class="text-2xl font-bold text-primary mb-4">{{ $movie->title ?? 'Movie Title' }}</h2>
                        <p class="text-gray-400 text-sm mb-4">
                            <i class="fas fa-hourglass-half text-primary mr-2"></i>
                            {{ $movie->duration ?? 165 }} Minutes
                        </p>
                        <p class="text-gray-400 text-sm mb-4">
                            <i class="fas fa-clapperboard text-primary mr-2"></i>
                            {{ $movie->genre ?? 'Sci-Fi' }}
                        </p>
                    </div>

                    <!-- Cinema Info -->
                    <div class="bg-secondary p-6 rounded-lg">
                        <h3 class="text-white font-bold mb-4">
                            <i class="fas fa-building text-primary mr-2"></i>Selected Cinema
                        </h3>
                        <h4 class="text-white font-bold text-lg mb-2">
                            @switch(request('cinema'))
                                @case(1) Grand Cinema Plaza @break
                                @case(2) Luxury Hall & Suites @break
                                @case(3) Starlight Multiplex @break
                                @case(4) The Orion Premium @break
                                @default Cinema @endswitch
                        </h4>
                        <p class="text-gray-400 text-sm">
                            @switch(request('cinema'))
                                @case(1) 452 Cinema Blvd, Arts District @break
                                @case(2) 88 Velvet Road, Downtown Core @break
                                @case(3) Westside Mall, 3rd Floor @break
                                @case(4) 123 Premium Ave, Uptown @break
                                @default Location @endswitch
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Date & Time Selection -->
            <div class="lg:col-span-2">
                <!-- Date Selection -->
                <h3 class="text-2xl font-bold text-white mb-6">Select Date</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-12">
                    @for ($i = 0; $i < 7; $i++)
                        @php
                            $date = now()->addDays($i);
                            $isToday = $i === 0;
                        @endphp
                        <button class="date-btn p-4 rounded-lg {{ $isToday ? 'bg-primary text-white' : 'bg-secondary text-gray-300 hover:bg-primary hover:text-white' }} transition font-bold" data-date="{{ $date->format('Y-m-d') }}">
                            <div class="text-xs mb-2">{{ $date->format('D') }}</div>
                            <div class="text-lg">{{ $date->format('d') }}</div>
                            <div class="text-xs">{{ $date->format('M') }}</div>
                        </button>
                    @endfor
                </div>

                <!-- Time Selection by Format -->
                <h3 class="text-2xl font-bold text-white mb-6">Select Format & Time</h3>
                <div class="space-y-8">
                    <!-- IMAX -->
                    <div class="bg-secondary p-6 rounded-lg">
                        <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i class="fas fa-film text-primary"></i>
                            IMAX
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @for ($j = 0; $j < 6; $j++)
                                @php
                                    $time = sprintf('%02d:%02d', 10 + ($j * 2), 0);
                                @endphp
                                <a href="{{ route('booking.seats') }}?movie={{ $movie->id }}&cinema={{ request('cinema') }}&format=IMAX&time={{ $time }}" 
                                    class="showtime-btn px-4 py-3 bg-neutral rounded text-center text-white font-semibold hover:bg-primary transition">
                                    {{ $time }}
                                </a>
                            @endfor
                        </div>
                    </div>

                    <!-- 4DX -->
                    <div class="bg-secondary p-6 rounded-lg">
                        <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i class="fas fa-magic text-primary"></i>
                            4DX
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @for ($j = 0; $j < 4; $j++)
                                @php
                                    $time = sprintf('%02d:%02d', 14 + ($j * 2), 30);
                                @endphp
                                <a href="{{ route('booking.seats') }}?movie={{ $movie->id }}&cinema={{ request('cinema') }}&format=4DX&time={{ $time }}" 
                                    class="showtime-btn px-4 py-3 bg-neutral rounded text-center text-white font-semibold hover:bg-primary transition">
                                    {{ $time }}
                                </a>
                            @endfor
                        </div>
                    </div>

                    <!-- Standard 2D -->
                    <div class="bg-secondary p-6 rounded-lg">
                        <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i class="fas fa-video text-primary"></i>
                            Standard (2D)
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @for ($j = 0; $j < 8; $j++)
                                @php
                                    $time = sprintf('%02d:%02d', 9 + ($j), 0);
                                @endphp
                                <a href="{{ route('booking.seats') }}?movie={{ $movie->id }}&cinema={{ request('cinema') }}&format=2D&time={{ $time }}" 
                                    class="showtime-btn px-4 py-3 bg-neutral rounded text-center text-white font-semibold hover:bg-primary transition">
                                    {{ $time }}
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Info -->
<section class="bg-secondary py-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <p class="text-gray-400 text-sm mb-2">Standard</p>
                <p class="text-3xl font-bold text-white">$12.50</p>
                <p class="text-gray-500 text-xs mt-2">per ticket</p>
            </div>
            <div class="text-center border-l border-r border-gray-700">
                <p class="text-gray-400 text-sm mb-2">Premium (IMAX/4DX)</p>
                <p class="text-3xl font-bold text-primary">$16.50</p>
                <p class="text-gray-500 text-xs mt-2">per ticket</p>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-sm mb-2">Special Event</p>
                <p class="text-3xl font-bold text-white">$20.00</p>
                <p class="text-gray-500 text-xs mt-2">per ticket</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateButtons = document.querySelectorAll('.date-btn');
    
    dateButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            dateButtons.forEach(b => {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('bg-secondary', 'text-gray-300');
            });
            this.classList.remove('bg-secondary', 'text-gray-300');
            this.classList.add('bg-primary', 'text-white');
        });
    });
});
</script>
@endsection
