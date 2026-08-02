@extends('layouts.app')

@section('title', 'Movies - Cinema Premium')

@section('content')
<!-- Movies Header -->
<section class="bg-gradient-to-r from-neutral to-secondary py-12 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-white mb-2 flex items-center gap-3">
            <i class="fas fa-film text-primary"></i>
            Browse Movies
        </h1>
        <p class="text-gray-400 text-lg">Find and book tickets for your favorite movies</p>
    </div>
</section>

<!-- Filters & Search -->
<section class="bg-neutral border-b border-gray-800 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="relative md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search movies..."
                    class="w-full bg-secondary px-4 py-3 rounded text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary">
                <i class="fas fa-search absolute right-4 top-4 text-gray-500"></i>
            </div>

            <!-- Genre Filter -->
            <select name="genre" class="bg-secondary px-4 py-3 rounded text-white focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Genres</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" @selected(request('genre') === $genre)>{{ $genre }}</option>
                @endforeach
            </select>

            <!-- Language Filter -->
            <select name="language" class="bg-secondary px-4 py-3 rounded text-white focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Languages</option>
                @foreach ($languages as $language)
                    <option value="{{ $language }}" @selected(request('language') === $language)>{{ $language }}</option>
                @endforeach
            </select>

            <!-- Status -->
            <div class="flex gap-2">
                <select name="status" class="flex-1 bg-secondary px-4 py-3 rounded text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Movies</option>
                    @foreach (['now_showing' => 'Now Showing', 'coming_soon' => 'Coming Soon', 'ended' => 'Ended'] as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-primary hover:bg-red-700 text-white px-5 rounded font-semibold transition">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Movies Grid -->
<section class="bg-neutral py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Movies Count -->
        <div class="mb-8">
            <p class="text-gray-400">
                <i class="fas fa-film text-primary mr-2"></i>
                Showing {{ $movies->count() }} of {{ $movies->total() }} movies
            </p>
        </div>

        <!-- Movies Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @forelse($movies ?? [] as $movie)
                <x-movie-card :movie="$movie" />
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-6xl text-gray-600 mb-4">
                        <i class="fas fa-film"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">No movies found</h3>
                    <p class="text-gray-500">Try adjusting your filters or search terms</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $movies->links() }}
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-primary to-red-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Can't find what you're looking for?</h2>
        <p class="text-gray-100 mb-6">Check our premium locations for more showtimes and exclusive offers</p>
        <a href="/" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-3 rounded font-bold hover:bg-gray-100 transition">
            <i class="fas fa-map-marker-alt"></i>
            Explore Locations
        </a>
    </div>
</section>
@endsection
