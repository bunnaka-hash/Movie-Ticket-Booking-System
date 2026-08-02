@extends('layouts.app')

@section('title', ($movie->title ?? 'Movie Details') . ' - Cinema Premium')

@section('content')

@php
    $poster = $movie->poster_url;
    $statusLabel = ucwords(str_replace('_', ' ', $movie->status));
@endphp

<!-- Hero -->
<section class="relative bg-gradient-to-r from-neutral via-secondary to-neutral overflow-hidden">
    <div class="absolute inset-0">
        <div class="w-full h-full bg-cover bg-center opacity-30" style="background-image: url('{{ $poster }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-neutral via-black/70 to-neutral"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col md:flex-row gap-10">
            <img src="{{ $poster }}" alt="{{ $movie->title }}"
                 onerror="this.onerror=null; this.src='{{ $movie->poster_placeholder }}';"
                 class="w-56 h-80 object-cover rounded-lg shadow-2xl shrink-0 bg-secondary">

            <div class="flex-1">
                <div class="inline-flex items-center gap-2 bg-primary text-white px-4 py-1 rounded-full text-xs font-bold mb-4">
                    <i class="fas fa-star"></i> {{ strtoupper($statusLabel) }}
                </div>

                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 leading-tight">{{ $movie->title }}</h1>

                <div class="text-gray-300 text-sm mb-6 flex flex-wrap gap-x-4 gap-y-2">
                    <span><i class="fas fa-film text-primary mr-1"></i>{{ $movie->genre }}</span>
                    <span>&bull;</span>
                    <span><i class="fas fa-hourglass-half text-primary mr-1"></i>{{ $movie->duration }} min</span>
                    <span>&bull;</span>
                    <span><i class="fas fa-volume-up text-primary mr-1"></i>{{ $movie->language }}</span>
                    @if ($movie->release_date)
                        <span>&bull;</span>
                        <span><i class="fas fa-calendar text-primary mr-1"></i>{{ $movie->release_date->format('M d, Y') }}</span>
                    @endif
                    @if ($movie->rating)
                        <span>&bull;</span>
                        <span class="text-yellow-400"><i class="fas fa-star mr-1"></i>{{ $movie->rating }}/10</span>
                    @endif
                </div>

                <p class="text-gray-300 max-w-3xl leading-relaxed mb-8">{{ $movie->description }}</p>

                <div class="flex flex-wrap gap-4">
                    @if ($showtimesByCinema->isNotEmpty())
                        <a href="#showtimes" class="inline-flex items-center bg-primary text-white px-6 py-3 rounded font-bold hover:bg-red-700 transition">
                            <i class="fas fa-ticket-alt mr-2"></i> Book Tickets
                        </a>
                    @endif
                    @if ($movie->trailer_url)
                        <a href="{{ $movie->trailer_url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center bg-secondary text-white px-6 py-3 rounded border border-gray-700 hover:border-primary transition">
                            <i class="fas fa-play mr-2"></i> Watch Trailer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Showtimes -->
<section id="showtimes" class="bg-neutral py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-8">
            <i class="fas fa-clock text-primary mr-2"></i> Showtimes
        </h2>

        @if ($dates->isEmpty())
            <div class="bg-secondary p-10 rounded-lg text-center">
                <i class="fas fa-calendar-times text-5xl text-gray-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-300 mb-2">No screenings scheduled</h3>
                <p class="text-gray-500">
                    @if ($movie->status === 'coming_soon')
                        This film is coming soon — check back for showtimes.
                    @else
                        There are no upcoming showtimes for this film right now.
                    @endif
                </p>
            </div>
        @else
            <!-- Date strip: only days that actually have screenings -->
            <div class="flex gap-3 mb-8 pb-2 overflow-x-auto">
                @foreach ($dates as $date)
                    @php $day = \Illuminate\Support\Carbon::parse($date); @endphp
                    <a href="{{ route('movies.show', ['movie' => $movie->id, 'date' => $date]) }}#showtimes"
                       class="flex flex-col items-center px-6 py-4 rounded transition whitespace-nowrap font-bold
                              {{ $date === $selectedDate ? 'bg-primary text-white' : 'bg-secondary text-gray-300 hover:bg-gray-700' }}">
                        <span class="text-xs mb-1 {{ $date === $selectedDate ? 'text-white' : 'text-gray-400' }}">
                            {{ $day->isToday() ? 'Today' : $day->format('M d') }}
                        </span>
                        <span class="text-lg">{{ $day->format('D') }}</span>
                    </a>
                @endforeach
            </div>

            <div class="space-y-6">
                @foreach ($showtimesByCinema as $cinemaName => $cinemaShowtimes)
                    @php $cinema = $cinemaShowtimes->first()->hall->cinema ?? null; @endphp
                    <div class="bg-secondary p-6 rounded-lg">
                        <h3 class="text-white font-bold mb-4 flex items-start gap-2">
                            <i class="fas fa-building text-primary mt-1"></i>
                            <span>
                                {{ $cinemaName }}
                                @if ($cinema)
                                    <br><span class="text-xs text-gray-400 font-normal">{{ $cinema->address }}, {{ $cinema->city }}</span>
                                @endif
                            </span>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            @foreach ($cinemaShowtimes as $showtime)
                                <a href="{{ route('booking.seats', $showtime) }}"
                                   class="px-3 py-3 bg-neutral rounded text-center hover:bg-primary transition group">
                                    <span class="block text-white text-sm font-semibold">
                                        {{ \Illuminate\Support\Carbon::parse($showtime->start_time)->format('H:i') }}
                                    </span>
                                    <span class="block text-xs text-gray-400 group-hover:text-white">
                                        {{ $showtime->hall->name }} &middot; ${{ number_format($showtime->price, 2) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @guest
                <p class="text-gray-500 text-sm mt-6">
                    <i class="fas fa-info-circle mr-1"></i>
                    You'll be asked to <a href="{{ route('login') }}" class="text-primary hover:underline">sign in</a> before choosing seats.
                </p>
            @endguest
        @endif
    </div>
</section>

<!-- Details -->
<section class="bg-secondary py-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <div>
                <p class="text-gray-400 text-xs mb-1"><i class="fas fa-hourglass-half text-primary mr-2"></i>DURATION</p>
                <p class="text-white font-bold">{{ $movie->duration }} Minutes</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1"><i class="fas fa-clapperboard text-primary mr-2"></i>GENRE</p>
                <p class="text-white font-bold">{{ $movie->genre }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1"><i class="fas fa-volume-up text-primary mr-2"></i>LANGUAGE</p>
                <p class="text-white font-bold">{{ $movie->language }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1"><i class="fas fa-star text-primary mr-2"></i>RATING</p>
                <p class="text-white font-bold">{{ $movie->rating ? $movie->rating . '/10' : 'Not rated' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1"><i class="fas fa-calendar text-primary mr-2"></i>RELEASE</p>
                <p class="text-white font-bold">{{ $movie->release_date?->format('M d, Y') ?? '—' }}</p>
            </div>
        </div>
    </div>
</section>

@endsection
