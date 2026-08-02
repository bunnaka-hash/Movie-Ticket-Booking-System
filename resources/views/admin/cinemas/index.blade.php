@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Cinemas Management</h1>
            <p class="text-gray-400 mt-2">{{ $cinemas->count() }} cinema branches</p>
        </div>
        <a href="{{ route('admin.cinemas.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Cinema
        </a>
    </div>

    <!-- Cinemas Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cinemas as $cinema)
            <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
                <h3 class="text-lg font-bold text-white mb-2">{{ $cinema->name }}</h3>
                <p class="text-gray-400 text-sm mb-1">{{ $cinema->address }}</p>
                <p class="text-gray-500 text-xs mb-4">
                    {{ $cinema->city }} &middot; <i class="fas fa-phone mr-1"></i>{{ $cinema->phone }}
                </p>
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-sm text-gray-300">
                        <i class="fas fa-chair text-primary mr-2"></i>{{ $cinema->halls_sum_total_seats ?? 0 }} Seats
                    </span>
                    <span class="text-sm text-gray-300">
                        <i class="fas fa-door-open text-primary mr-2"></i>{{ $cinema->halls_count }} Halls
                    </span>
                </div>
                <div class="flex gap-2 pt-4 border-t border-gray-700">
                    <a href="{{ route('admin.cinemas.edit', $cinema) }}" class="flex-1 py-2 bg-primary hover:bg-red-700 text-white text-center rounded font-semibold text-sm transition">Edit</a>

                    <form method="POST" action="{{ route('admin.cinemas.destroy', $cinema) }}" class="flex-1"
                          onsubmit="return confirm('Delete &quot;{{ $cinema->name }}&quot;? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-900 hover:bg-red-800 text-white text-center rounded font-semibold text-sm transition">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic">No cinemas yet.</p>
        @endforelse
    </div>
</div>

@endsection
