@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Showtimes Management</h1>
            <p class="text-gray-400 mt-2">{{ $showtimes->total() }} showtimes scheduled</p>
        </div>
        <a href="{{ route('admin.showtimes.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Showtime
        </a>
    </div>

    <!-- Filter -->
    <form method="GET" class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <select name="movie_id" class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option value="">All Movies</option>
            @foreach ($movies as $movie)
                <option value="{{ $movie->id }}" @selected(request('movie_id') == $movie->id)>{{ $movie->title }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}"
               class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-2 rounded font-semibold transition">
            Filter
        </button>
    </form>

    <!-- Showtimes Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Movie</th>
                    <th class="text-left py-4 px-4 text-gray-400">Cinema</th>
                    <th class="text-left py-4 px-4 text-gray-400">Hall</th>
                    <th class="text-left py-4 px-4 text-gray-400">Date & Time</th>
                    <th class="text-left py-4 px-4 text-gray-400">Price</th>
                    <th class="text-left py-4 px-4 text-gray-400">Bookings</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($showtimes as $showtime)
                    @php $start = \Illuminate\Support\Carbon::parse($showtime->start_time); @endphp
                    <tr class="border-b border-gray-800 hover:bg-neutral transition">
                        <td class="py-4 px-4 text-white font-semibold">{{ $showtime->movie->title ?? '—' }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $showtime->hall->cinema->name ?? '—' }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $showtime->hall->name ?? '—' }}</td>
                        <td class="py-4 px-4 text-gray-300">
                            {{ $start->format('M d, Y - H:i') }}
                            @if ($start->isPast())
                                <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded text-xs ml-2">Finished</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-primary font-semibold">${{ number_format($showtime->price, 2) }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $showtime->bookings_count }}</td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.showtimes.edit', $showtime) }}" class="text-primary hover:text-red-400 mr-3">Edit</a>

                            <form method="POST" action="{{ route('admin.showtimes.destroy', $showtime) }}" class="inline"
                                  onsubmit="return confirm('Delete this showtime? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 px-4 text-center text-gray-500 italic">No showtimes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $showtimes->links() }}
        </div>
    </div>
</div>

@endsection
