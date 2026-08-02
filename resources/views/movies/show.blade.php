@extends('layouts.app')

@section('title', '{{ $movie->title ?? "Movie Details" }} - Cinema Premium')

@section('content')
<!-- Hero Section with Movie Details -->
<section class="relative h-screen bg-gradient-to-r from-neutral via-secondary to-neutral overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <div class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $movie->poster_url ?? "/images/posters/placeholder.jpg" }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-neutral via-black/50 to-neutral"></div>
    </div>

    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <!-- Release Badge -->
        <div class="mb-6">
            <div class="inline-flex items-center gap-3 bg-primary text-white px-4 py-2 rounded-full text-sm font-bold mb-6">
                <i class="fas fa-star"></i>
                NEW RELEASE
            </div>

            <!-- Movie Meta Info -->
            <div class="text-gray-300 text-sm mb-4 space-x-4">
                <span><i class="fas fa-film text-primary mr-1"></i>SCI-FI</span>
                <span>•</span>
                <span><i class="fas fa-calendar text-primary mr-1"></i>2168</span>
                <span>•</span>
                <span><i class="fas fa-hourglass text-primary mr-1"></i>2024</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-6xl md:text-7xl font-bold text-white mb-8 leading-tight">
            {{ $movie->title ?? 'Movie Title' }}
        </h1>

        <!-- CTA Buttons -->
        <div class="flex gap-4">
            <a href="#" class="inline-flex items-center justify-center bg-primary text-white px-6 py-3 rounded font-bold hover:bg-red-700 transition">
                <i class="fas fa-play mr-2"></i>
                WATCH TRAILER
            </a>
            <button class="inline-flex items-center justify-center bg-secondary text-white px-6 py-3 rounded border border-gray-700 hover:border-primary transition">
                <i class="fas fa-plus text-lg"></i>
            </button>
        </div>
    </div>
</section>

<!-- Quick Info Bar -->
<section class="bg-secondary border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <div>
                <p class="text-gray-400 text-xs mb-1 flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-primary"></i>DURATION
                </p>
                <p class="text-white font-bold">{{ $movie->duration ?? 165 }} Minutes</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1 flex items-center gap-2">
                    <i class="fas fa-clapperboard text-primary"></i>GENRE
                </p>
                <p class="text-white font-bold">{{ $movie->genre ?? 'Sci-Fi' }} / Drama</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1 flex items-center gap-2">
                    <i class="fas fa-certificate text-primary"></i>RATING
                </p>
                <p class="text-white font-bold">13+</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1 flex items-center gap-2">
                    <i class="fas fa-volume-up text-primary"></i>LANGUAGE
                </p>
                <p class="text-white font-bold">ENG / ESP</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1 flex items-center gap-2">
                    <i class="fas fa-star text-primary"></i>RELEASE
                </p>
                <p class="text-white font-bold">{{ isset($movie->release_date) ? $movie->release_date->format('M d, Y') : 'Today' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="bg-neutral py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Synopsis -->
                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">Synopsis</h2>
                    <p class="text-gray-400 leading-relaxed">
                        {{ $movie->description ?? 'In the year 2168, Earths communication network is hijacked by a rogue AI known as the "Nebula Protocol." Commander Aria Vane must lead a desperate mission across the sub-orbital colonies to unseal the breach between worlds. As the line between man and machine blurs, Vane discovers that the protocol isn\'t just a virus—it\'s an evolution.' }}
                    </p>
                </div>

                <!-- Leading Cast -->
                <div class="display: flex; flex-direction: row;">
                    <h2 class="text-2xl font-bold text-white mb-6">Leading Cast</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="text-center group">
                                <div class="w-full h-40 bg-secondary rounded mb-3 flex items-center justify-center overflow-hidden group-hover:shadow-lg group-hover:shadow-primary/30 transition">
                                    <i class="fas fa-user text-3xl text-gray-600"></i>
                                </div>
                                <h4 class="text-white font-bold text-sm group-hover:text-primary transition">
                                    @switch($i)
                                        @case(1) Aria Vane @break
                                        @case(2) Elara Ky @break
                                        @case(3) Ambassador @break
                                        @case(4) Jaxen @break
                                    @endswitch
                                </h4>
                                <p class="text-gray-400 text-xs">Main Cast</p>
                            </div>
                        @endfor
                    </div>
                    <!-- Reviews -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Reviews</h2>
                        <a href="#" class="text-primary hover:text-red-400 transition text-sm font-semibold">
                            Write a Review
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @for ($i = 1; $i <= 2; $i++)
                            <div class="bg-secondary p-6 rounded-lg">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 bg-neutral rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold text-sm">
                                                @switch($i)
                                                    @case(1) Sarah Jenkins @break
                                                    @case(2) Mike Ross @break
                                                @endswitch
                                            </h4>
                                            <p class="text-gray-400 text-xs">
                                                @switch($i)
                                                    @case(1) Verified Buyer @break
                                                    @case(2) For Fans @break
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-1">
                                        @for ($j = 0; $j < 5; $j++)
                                            <i class="fas fa-star text-primary text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-400 text-sm leading-relaxed">
                                    @switch($i)
                                        @case(1)
                                            "A visual masterpiece. The world-building in Nebula Protocol is unlike anything I've seen in the last decade. Must watch in IMAX!"
                                            @break
                                        @case(2)
                                            "Deeply emotional and technically flawless. Oscar-level delivers a career-best performance as Aria Vane."
                                            @break
                                    @endswitch
                                </p>
                            </div>
                        @endfor
                    </div>
                </div>
                </div>

<!-- Cinema Selection Section -->
<section class="bg-secondary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-white mb-6 flex items-center gap-3">
            <i class="fas fa-map-marker-alt text-primary"></i>
            Find a Cinema
        </h2>
        <p class="text-gray-400 mb-8">Explore premium cinematic experiences near you.</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cinema List -->
            <div class="lg:col-span-1">
                <!-- Search and Filters -->
                <div class="mb-6">
                    <div class="relative mb-6">
                        <i class="fas fa-building absolute left-4 top-4 text-gray-500"></i>
                        <input type="text" id="cinemaSearch" placeholder="Enter city, region or zip code"
                            class="w-full bg-neutral px-4 py-3 pl-12 rounded text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>

                    <!-- Format Filters -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <button class="px-4 py-2 bg-neutral border border-primary text-primary rounded hover:bg-primary hover:text-white transition font-semibold text-sm">
                            <i class="fas fa-crown mr-2"></i>Gold Class
                        </button>
                        <button class="px-4 py-2 bg-neutral text-gray-300 rounded hover:bg-primary hover:text-white hover:border-primary transition font-semibold text-sm">
                            Velvet
                        </button>
                        <button class="px-4 py-2 bg-neutral text-gray-300 rounded hover:bg-primary hover:text-white hover:border-primary transition font-semibold text-sm">
                            IMAX
                        </button>
                        <button class="px-4 py-2 bg-neutral text-gray-300 rounded hover:bg-primary hover:text-white hover:border-primary transition font-semibold text-sm">
                            4DX
                        </button>
                    </div>
                </div>

                <!-- Cinemas List -->
                <div class="space-y-4" id="cinemaList">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="cinema-card bg-neutral p-6 rounded-lg border-2 border-gray-700 hover:border-primary transition cursor-pointer" data-cinema-id="{{ $i }}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-white font-bold text-lg mb-1">
                                        @switch($i)
                                            @case(1) Grand Cinema Plaza @break
                                            @case(2) Luxury Hall & Suites @break
                                            @case(3) Starlight Multiplex @break
                                            @case(4) The Orion Premium @break
                                        @endswitch
                                    </h3>
                                    <p class="text-primary text-sm font-semibold">
                                        @switch($i)
                                            @case(1) 2.4 km away @break
                                            @case(2) 3.8 km away @break
                                            @case(3) 5.1 km away @break
                                            @case(4) 7.4 km away @break
                                        @endswitch
                                    </p>
                                </div>
                                <button class="w-10 h-10 bg-primary rounded-full text-white flex items-center justify-center hover:bg-red-700 transition">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <p class="text-gray-400 text-sm mb-4">
                                @switch($i)
                                    @case(1) 452 Cinema Blvd, Arts District, Metropolis @break
                                    @case(2) 88 Velvet Road, Downtown Core @break
                                    @case(3) Westside Mall, 3rd Floor, Metropolis @break
                                    @case(4) 123 Premium Ave, Uptown District @break
                                @endswitch
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @switch($i)
                                    @case(1)
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">PARKING</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">FOOD COURT</span>
                                        <span class="text-xs bg-secondary text-primary px-3 py-1 rounded border border-primary">IMAX</span>
                                        @break
                                    @case(2)
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">GOLD CLASS</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">VELVET</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">BAR</span>
                                        @break
                                    @case(3)
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">PARKING</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">KIDS ZONE</span>
                                        @break
                                    @case(4)
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">PREMIUM</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">4DX</span>
                                        <span class="text-xs bg-secondary text-gray-300 px-3 py-1 rounded">LOUNGE</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Map -->
            <div class="lg:col-span-2">
                <div class="w-full h-96 md:h-full bg-gray-800 rounded-lg overflow-hidden relative min-h-96">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        style="border:0" 
                        loading="lazy" 
                        allowfullscreen="" 
                        referrerpolicy="no-referrer-when-downgrade" 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.195404628849!2d-118.24367!3d34.0522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da49%3A0xaded2a89b140da!2sLos%20Angeles!5e0!3m2!1sen!2sus!4v1627000000000">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Showtimes -->
<section id="showtimes">
                    
                    <!-- Date Selection -->
                    <div class="flex gap-3 mb-8 pb-2 overflow-x-auto">
                        @for ($i = 0; $i < 7; $i++)
                            @php
                                $date = now()->addDays($i);
                                $isToday = $i === 0;
                            @endphp
                            <button class="flex flex-col items-center px-6 py-4 rounded {{ $isToday ? 'bg-primary' : 'bg-secondary hover:bg-gray-700' }} transition whitespace-nowrap font-bold">
                                <span class="text-xs {{ $isToday ? 'text-white' : 'text-gray-400' }} mb-1">{{ $date->format('M d') }}</span>
                                <span class="text-lg text-white">{{ $date->format('D') }}</span>
                            </button>
                        @endfor
                    </div>

                    <!-- Cinemas and Showtimes -->
                    <div class="space-y-6">
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="bg-secondary p-6 rounded-lg">
                                <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                                    <i class="fas fa-building text-primary"></i>
                                    @switch($i)
                                        @case(1)
                                            Cinema Premium Downtown
                                            <br><span class="text-xs text-gray-400 font-normal">0 Sm Ave, Manhattan</span>
                                            @break
                                        @case(2)
                                            Grand Theater Plaza
                                            <br><span class="text-xs text-gray-400 font-normal">9 Sunset Blvd, LA</span>
                                            @break
                                        @case(3)
                                            Titan Cineplex
                                            <br><span class="text-xs text-gray-400 font-normal">Tech Valley, Suburbs</span>
                                            @break
                                    @endswitch
                                </h3>
                                <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
                                    @for ($j = 0; $j < 6; $j++)
                                        @php
                                            $time = sprintf('%02d:%02d', 14 + ($j % 3) * 2, ($j % 2) * 30);
                                        @endphp
                                        <a href="{{ route('booking.seats', ['movie' => $movie->id ?? 1, 'cinema' => $i, 'time' => $time]) }}"
                                            class="px-3 py-3 bg-neutral rounded text-center text-white text-sm font-semibold hover:bg-primary transition">
                                            {{ $time }}
                                        </a>
                                    @endfor
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Available Formats -->
                <div class="bg-secondary p-6 rounded-lg mb-6 sticky top-24">
                    <h3 class="text-white font-bold mb-4">Available Formats</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="px-4 py-2 bg-neutral rounded text-center text-white text-sm font-semibold hover:bg-primary transition">
                            IMAX
                        </button>
                        <button class="px-4 py-2 bg-neutral rounded text-center text-white text-sm font-semibold hover:bg-primary transition">
                            4DX
                        </button>
                        <button class="px-4 py-2 bg-neutral rounded text-center text-white text-sm font-semibold hover:bg-primary transition">
                            3D
                        </button>
                        <button class="px-4 py-2 bg-primary rounded text-center text-white text-sm font-semibold hover:bg-red-700 transition">
                            2D
                        </button>
                    </div>
                </div>

                <!-- User Score -->
                <div class="bg-secondary p-6 rounded-lg mb-6">
                    <h3 class="text-white font-bold mb-4">User Score</h3>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-primary mb-2">4.9/5</div>
                        <div class="flex justify-center gap-1 mb-3">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-primary text-sm"></i>
                            @endfor
                        </div>
                        <p class="text-gray-400 text-xs">Based on 12.4k reviews</p>
                    </div>
                </div>

                <!-- Genres & Details -->
                <div class="bg-secondary p-6 rounded-lg mb-6">
                    <h3 class="text-white font-bold mb-4">Details</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-300 text-sm">
                            <i class="fas fa-tag text-primary mt-1"></i>
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Genre</p>
                                <p class="text-white font-semibold">{{ $movie->genre ?? 'Sci-Fi' }} / Action</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-300 text-sm border-t border-gray-700 pt-3">
                            <i class="fas fa-globe text-primary mt-1"></i>
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Language</p>
                                <p class="text-white font-semibold">English, Spanish</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 text-gray-300 text-sm border-t border-gray-700 pt-3">
                            <i class="fas fa-certificate text-primary mt-1"></i>
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Rating</p>
                                <p class="text-white font-semibold">13+ (PG)</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Share -->
                <div class="bg-secondary p-6 rounded-lg">
                    <h3 class="text-white font-bold mb-4">Share Movie</h3>
                    <div class="grid grid-cols-4 gap-2">
                        <a href="#" class="py-3 bg-neutral rounded text-center text-gray-300 hover:text-white hover:bg-primary/20 transition">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="py-3 bg-neutral rounded text-center text-gray-300 hover:text-white hover:bg-primary/20 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="py-3 bg-neutral rounded text-center text-gray-300 hover:text-white hover:bg-primary/20 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="py-3 bg-neutral rounded text-center text-gray-300 hover:text-white hover:bg-primary/20 transition">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bottom Booking Bar -->
<section class="fixed bottom-0 left-0 right-0 bg-secondary border-t border-gray-800 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div id="selectedCinemaInfo" class="hidden">
                <p class="text-gray-400 text-sm mb-1">SELECTED CINEMA</p>
                <p class="text-white font-bold flex items-center gap-2">
                    <i class="fas fa-building text-primary"></i>
                    <span id="selectedCinemaName">Select a cinema</span>
                </p>
            </div>
            <div id="noSelection" class="block">
                <p class="text-gray-400 text-sm">Please select a cinema first</p>
            </div>
            <div class="w-full md:w-auto flex items-center gap-4">
                <!-- <p class="text-gray-400 text-sm">TOTAL PRICE</p>
                <p class="text-3xl font-bold text-primary">$48.50</p> -->
                <a href="#" id="bookTicketsBtn" class="inline-flex items-center justify-center bg-gray-600 text-white px-8 py-3 rounded font-bold transition cursor-not-allowed" disabled>
                    BOOK TICKETS
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Spacing for bottom bar -->
<div class="h-32"></div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cinemaCards = document.querySelectorAll('.cinema-card');
    const bookTicketsBtn = document.getElementById('bookTicketsBtn');
    const selectedCinemaInfo = document.getElementById('selectedCinemaInfo');
    const noSelection = document.getElementById('noSelection');
    const selectedCinemaName = document.getElementById('selectedCinemaName');
    let selectedCinemaId = null;

    // Cinema Selection
    cinemaCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove previous selection
            cinemaCards.forEach(c => c.classList.remove('border-primary', 'bg-neutral'));
            cinemaCards.forEach(c => c.classList.add('border-gray-700'));

            // Mark this one as selected
            this.classList.remove('border-gray-700');
            this.classList.add('border-primary');
            
            // Get cinema name
            selectedCinemaId = this.getAttribute('data-cinema-id');
            const cinemaName = this.querySelector('h3').textContent.trim();
            selectedCinemaName.textContent = cinemaName;

            // Update UI
            selectedCinemaInfo.classList.remove('hidden');
            selectedCinemaInfo.classList.add('block');
            noSelection.classList.remove('block');
            noSelection.classList.add('hidden');

            // Enable Book Tickets Button
            bookTicketsBtn.classList.remove('bg-gray-600', 'cursor-not-allowed');
            bookTicketsBtn.classList.add('bg-primary', 'hover:bg-red-700', 'cursor-pointer');
            bookTicketsBtn.removeAttribute('disabled');
            
            // Update link
            bookTicketsBtn.href = `/movies/{{ $movie->id }}/showtime?cinema=${selectedCinemaId}`;
        });
    });

    // Keep button disabled if nothing selected
    if (!selectedCinemaId) {
        bookTicketsBtn.setAttribute('disabled', 'disabled');
    }
});
</script>
