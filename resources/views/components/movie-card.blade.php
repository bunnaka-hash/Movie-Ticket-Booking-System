<!-- Movie Card Component -->
<div class="group">
    <div class="relative overflow-hidden rounded-lg mb-4">
        <!-- Poster Image -->
        <img src="{{ $movie->poster_url ?? '/images/posters/placeholder.jpg' }}" 
            alt="{{ $movie->title ?? 'Movie Title' }}"
            class="w-full h-80 object-cover group-hover:scale-110 transition duration-300">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
            <a href="{{ route('movies.show', $movie->id) }}" class="bg-primary text-white px-6 py-3 rounded font-bold hover:bg-red-700 transition transform hover:scale-105 flex items-center gap-2">
                <i class="fas fa-play"></i>
                Watch
            </a>
        </div>
        
        <!-- Rating Badge -->
        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full font-bold text-sm">
            {{ $movie->rating ?? '8.5' }}/10
        </div>

        <!-- Duration Badge -->
        @if($movie->duration ?? null)
            <div class="absolute top-4 left-4 bg-secondary text-gray-300 px-3 py-1 rounded-full text-sm flex items-center gap-1">
                <i class="fas fa-hourglass-half"></i>
                {{ $movie->duration }} min
            </div>
        @endif
    </div>

    <!-- Movie Info -->
    <h3 class="text-white font-bold text-lg mb-1 group-hover:text-primary transition line-clamp-1">
        {{ $movie->title ?? 'Movie Title' }}
    </h3>
    <p class="text-gray-400 text-sm mb-3">
        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
        {{ isset($movie->release_date) ? $movie->release_date->format('M d, Y') : 'Aug 2, 2026' }}
    </p>
    <div class="flex flex-wrap gap-2">
        @if($movie->genre ?? null)
            <span class="bg-secondary text-gray-300 px-3 py-1 rounded text-xs">
                {{ $movie->genre }}
            </span>
        @endif
        @if($movie->language ?? null)
            <span class="bg-secondary text-gray-300 px-3 py-1 rounded text-xs flex items-center gap-1">
                <i class="fas fa-volume-up text-xs"></i>
                {{ $movie->language }}
            </span>
        @endif
    </div>
</div>