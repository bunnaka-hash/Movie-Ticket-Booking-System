@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Movies Management</h1>
            <p class="text-gray-400 mt-2">{{ $movies->total() }} movies in your system</p>
        </div>
        <a href="{{ route('admin.movies.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Movie
        </a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by title or genre..."
               class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <select name="status" class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option value="">All Status</option>
            @foreach (['now_showing' => 'Now Showing', 'coming_soon' => 'Coming Soon', 'ended' => 'Ended'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-2 rounded font-semibold transition">
            Filter
        </button>
    </form>

    <!-- Movies Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Poster</th>
                    <th class="text-left py-4 px-4 text-gray-400">Title</th>
                    <th class="text-left py-4 px-4 text-gray-400">Genre</th>
                    <th class="text-left py-4 px-4 text-gray-400">Duration</th>
                    <th class="text-left py-4 px-4 text-gray-400">Rating</th>
                    <th class="text-left py-4 px-4 text-gray-400">Showtimes</th>
                    <th class="text-left py-4 px-4 text-gray-400">Status</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movies as $movie)
                    <tr class="border-b border-gray-800 hover:bg-neutral transition">
                        <td class="py-2 px-4">
                            <img src="{{ $movie->poster_url }}" alt=""
                                 onerror="this.onerror=null; this.src='{{ $movie->poster_placeholder }}';"
                                 class="w-10 h-14 object-cover rounded bg-neutral border border-gray-700">
                        </td>
                        <td class="py-4 px-4 text-white font-semibold">{{ $movie->title }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $movie->genre }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $movie->duration }} min</td>
                        <td class="py-4 px-4">
                            <span class="flex items-center gap-1 text-yellow-400">
                                <i class="fas fa-star"></i> {{ $movie->rating ?? '—' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-gray-300">{{ $movie->showtimes_count }}</td>
                        <td class="py-4 px-4">
                            @php
                                $badge = match ($movie->status) {
                                    'now_showing' => 'bg-green-900 text-green-200',
                                    'coming_soon' => 'bg-yellow-900 text-yellow-200',
                                    default => 'bg-gray-800 text-gray-300',
                                };
                            @endphp
                            <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">
                                {{ ucwords(str_replace('_', ' ', $movie->status)) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="text-primary hover:text-red-400 mr-3">Edit</a>

                            <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}" class="inline"
                                  onsubmit="return confirm('Delete &quot;{{ $movie->title }}&quot;? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 px-4 text-center text-gray-500 italic">No movies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $movies->links() }}
        </div>
    </div>
</div>

@endsection
