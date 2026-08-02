@extends('layouts.app')

@section('title', 'Home - Cinema Premium')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen bg-gradient-to-r from-neutral via-secondary to-neutral overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 opacity-20">
        <div class="w-full h-full bg-cover bg-center" style="background-image: url('/images/hero/hero-bg.jpg')"></div>
    </div>

    <!-- Animated Shapes -->
    <div class="absolute top-10 right-10 w-40 h-40 bg-primary opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-60 h-60 bg-tertiary opacity-10 rounded-full blur-3xl"></div>

    <!-- Content -->
    <div class="relative h-full flex flex-col justify-center items-start max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-full mb-6 text-sm font-semibold">
                <i class="fas fa-star"></i>
                NOW SHOWING
            </div>

            <!-- Title -->
            <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight tracking-tight">
                INTERSTELLAR:<br>REBORN
            </h1>

            <!-- Description -->
            <p class="text-gray-300 text-lg md:text-xl max-w-2xl mb-8 leading-relaxed">
                The journey beyond the silent universe is ignited by a rogue AI known as the "Nemesis Protocol." Uncover the riddles and save humanity.
            </p>

            <!-- Genres -->
            <div class="flex flex-wrap gap-3 mb-8">
                <span class="bg-secondary px-4 py-2 rounded text-sm text-gray-300 border border-gray-700">
                    <i class="fas fa-clapperboard mr-2 text-primary"></i>Sci-Fi
                </span>
                <span class="bg-secondary px-4 py-2 rounded text-sm text-gray-300 border border-gray-700">
                    <i class="fas fa-film mr-2 text-primary"></i>Action
                </span>
                <span class="bg-secondary px-4 py-2 rounded text-sm text-gray-300 border border-gray-700">
                    <i class="fas fa-bolt mr-2 text-primary"></i>Thriller
                </span>
            </div>

            <!-- Rating & Duration -->
            <div class="flex flex-wrap gap-6 mb-10 text-gray-300">
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    <span class="text-sm">Released Today, 2026</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-primary"></i>
                    <span class="text-sm">168 Min • 3h 45m</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-closed-captioning text-primary"></i>
                    <span class="text-sm">IMAX</span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#" class="inline-flex items-center justify-center bg-primary text-white px-8 py-4 rounded font-bold hover:bg-red-700 transition transform hover:scale-105">
                    <i class="fas fa-play mr-3"></i>
                    WATCH TRAILER
                </a>
                <a href="#" class="inline-flex items-center justify-center bg-transparent border-2 border-primary text-primary px-8 py-4 rounded font-bold hover:bg-primary hover:text-white transition">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    BOOK TICKETS
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Now Showing Section -->
<section class="bg-neutral py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-2 flex items-center gap-3">
                    <i class="fas fa-film text-primary"></i>
                    Now Showing
                </h2>
                <p class="text-gray-400">Latest movies in theaters</p>
            </div>
            <a href="/movies" class="text-primary hover:text-red-400 transition font-semibold flex items-center gap-2">
                View All
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Movie Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($nowShowing ?? [] as $movie)
                <!-- Movie Card -->
                <div class="group cursor-pointer">
                    <a href="{{ route('movies.show', $movie->id) }}" class="relative overflow-hidden rounded-lg mb-4 block">
                        <!-- Poster Image -->
                        <img src="{{ $movie->poster_url }}"
                            alt="{{ $movie->title }}"
                            onerror="this.onerror=null; this.src='{{ $movie->poster_placeholder }}';"
                            class="w-full h-80 object-cover bg-secondary group-hover:scale-110 transition duration-300">
                        
                        <!-- Rating Badge -->
                        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full font-bold text-sm">
                            {{ $movie->rating ?? '8.5' }}/10
                        </div>
                    </a>

                    <!-- Movie Info -->
                    <a href="{{ route('movies.show', $movie->id) }}" class="block">
                        <h3 class="text-white font-bold text-lg mb-1 group-hover:text-primary transition">
                            {{ $movie->title ?? 'Movie Title' }}
                        </h3>
                    </a>
                    <p class="text-gray-400 text-sm mb-3">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                        {{ $movie->release_date ?? 'Aug 2, 2026' }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-secondary text-gray-300 px-3 py-1 rounded text-xs">
                            {{ $movie->genre ?? 'Sci-Fi' }}
                        </span>
                    </div>
                </div>
            @empty
                <!-- Demo Cards -->
                @for ($i = 1; $i <= 4; $i++)
                    <div class="group cursor-pointer">
                        <a href="#" class="relative overflow-hidden rounded-lg mb-4 block">
                            <div class="relative overflow-hidden rounded-lg bg-secondary h-80 flex items-center justify-center">
                                <div class="text-gray-600 text-center">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p class="text-sm">Movie Poster</p>
                                </div>
                            </div>
                        </a>

                        <h3 class="text-white font-bold text-lg mb-1">
                            Movie Title {{ $i }}
                        </h3>

                        <p class="text-gray-400 text-sm mb-3">
                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                            Aug {{ $i + 1 }}, 2026
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <span class="bg-secondary text-gray-300 px-3 py-1 rounded text-xs">
                                Sci-Fi
                            </span>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <!-- View More Button -->
        <div class="text-center">
            <a href="/movies" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded font-bold hover:bg-red-700 transition">
                <i class="fas fa-arrow-right"></i>
                View More Movies
            </a>
        </div>
    </div>
</section>

<!-- Coming Soon Section -->
<section class="bg-secondary py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-2 flex items-center gap-3">
                    <i class="fas fa-clock text-primary"></i>
                    Coming Soon
                </h2>
                <p class="text-gray-400">Upcoming movies to watch for</p>
            </div>
        </div>

        <!-- Movie Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @for ($i = 1; $i <= 3; $i++)
                <div class="group relative overflow-hidden rounded-lg">
                    <div class="relative h-96 bg-gradient-to-br from-tertiary to-secondary flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 opacity-30">
                            <i class="fas fa-mountain text-white text-9xl absolute -top-10 -left-10"></i>
                        </div>
                        <div class="relative text-center">
                            <div class="text-7xl mb-4 text-white opacity-50">
                                <i class="fas fa-film"></i>
                            </div>
                            <p class="text-gray-300 text-sm">Coming Soon</p>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition duration-300">
                        <h3 class="text-white font-bold text-lg mb-2">Upcoming Movie {{ $i }}</h3>
                        <p class="text-gray-300 text-sm mb-4">Coming in {{ $i + 1 }} months</p>
                        <button class="w-full bg-primary text-white px-4 py-2 rounded font-bold hover:bg-red-700 transition">
                            Notify Me
                        </button>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

<!-- Premium Membership Section -->
<section class="bg-neutral py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div>
                <div class="inline-block bg-primary text-white px-4 py-2 rounded-full mb-6 font-semibold text-sm">
                    <i class="fas fa-crown mr-2"></i>EXCLUSIVE OFFER
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    PREMIUM GOLD<br>MEMBERSHIP
                </h2>
                <p class="text-gray-400 text-lg mb-8">
                    Unlock unlimited access to our cinema journey with premium perks, exclusive deals and more.
                </p>

                <!-- Features -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-gray-300">
                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Complimentary Perks & Benefits
                    </li>
                    <li class="flex items-center gap-3 text-gray-300">
                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Unlimited Bookings & Discounts
                    </li>
                    <li class="flex items-center gap-3 text-gray-300">
                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        Priority Support for all members
                    </li>
                </ul>

                <!-- CTA Button -->
                <a href="#" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded font-bold hover:bg-red-700 transition transform hover:scale-105">
                    <i class="fas fa-upgrade"></i>
                    Upgrade to Gold - 25% Months
                </a>
            </div>

            <!-- Card Design -->
            <div class="relative h-96">
                <div class="absolute inset-0 bg-gradient-to-br from-primary to-red-900 rounded-2xl p-8 transform hover:scale-105 transition duration-300 shadow-2xl">
                    <div class="h-full flex flex-col justify-between text-white">
                        <div>
                            <div class="flex justify-between items-start mb-12">
                                <div>
                                    <p class="text-gray-200 text-sm">CINEMA PREMIUM</p>
                                    <p class="text-3xl font-bold">GOLD</p>
                                </div>
                                <div class="text-4xl opacity-50">
                                    <i class="fas fa-crown"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-bold">UNLIMITED</p>
                        </div>
                        <div>
                            <p class="text-sm mb-4">Alexander Holland</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-mono">**** **** **** ****</span>
                                <div class="w-12 h-8 bg-yellow-300 rounded opacity-80"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Badge -->
                <div class="absolute bottom-8 right-8 bg-yellow-300 text-secondary rounded-full w-20 h-20 flex items-center justify-center font-bold text-center p-2 shadow-lg">
                    <span>SOLD OUT</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Locations Section -->
<section class="bg-secondary py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center justify-center gap-3">
                <i class="fas fa-map-marker-alt text-primary"></i>
                Premium Locations
            </h2>
            <p class="text-gray-400 text-lg">Find the ultimate cinema experience near you</p>
        </div>

        <!-- Locations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 4; $i++)
                <div class="bg-neutral rounded-lg p-6 hover:shadow-lg hover:shadow-primary/30 transition group cursor-pointer">
                    <div class="mb-4 flex items-center justify-between">
                        <i class="fas fa-building text-3xl text-primary opacity-50 group-hover:opacity-100 transition"></i>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2 group-hover:text-primary transition">
                        @switch($i)
                            @case(1)
                                Grand Plaza Hotel
                                @break
                            @case(2)
                                The Dray Boutique
                                @break
                            @case(3)
                                Titan Squared
                                @break
                            @case(4)
                                Pad Mura
                                @break
                        @endswitch
                    </h3>
                    <p class="text-gray-400 text-sm mb-4">
                        @switch($i)
                            @case(1)
                                Downtown District, Metro
                                @break
                            @case(2)
                                Waterfront Sector District
                                @break
                            @case(3)
                                Tech Valley, Suburbs
                                @break
                            @case(4)
                                Research Sector City Offica
                                @break
                        @endswitch
                    </p>
                    <button class="text-primary hover:text-red-400 transition font-semibold text-sm flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                        View Cinemas
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            @endfor
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-gradient-to-r from-primary to-red-900 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 flex items-center justify-center gap-3">
            <i class="fas fa-ticket-alt"></i>
            Ready to Book Your Tickets?
        </h2>
        <p class="text-gray-100 text-lg mb-8 max-w-2xl mx-auto">
            Enjoy the ultimate movie experience with premium sound, crystal-clear visuals, and comfortable seating.
        </p>
        <a href="/movies" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded font-bold hover:bg-gray-100 transition transform hover:scale-105">
            <i class="fas fa-search"></i>
            Explore Movies Now
        </a>
    </div>
</section>
@endsection