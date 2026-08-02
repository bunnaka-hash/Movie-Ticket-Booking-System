@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Halls Management</h1>
            <p class="text-gray-400 mt-2">{{ $halls->count() }} halls across all cinemas</p>
        </div>
        <a href="{{ route('admin.halls.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Hall
        </a>
    </div>

    <!-- Halls Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Hall Name</th>
                    <th class="text-left py-4 px-4 text-gray-400">Cinema</th>
                    <th class="text-left py-4 px-4 text-gray-400">Capacity</th>
                    <th class="text-left py-4 px-4 text-gray-400">Seats Created</th>
                    <th class="text-left py-4 px-4 text-gray-400">Showtimes</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($halls as $hall)
                    <tr class="border-b border-gray-800 hover:bg-neutral transition">
                        <td class="py-4 px-4 text-white font-semibold">{{ $hall->name }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $hall->cinema->name ?? '—' }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $hall->total_seats }} Seats</td>
                        <td class="py-4 px-4">
                            @if ($hall->seats_count === $hall->total_seats)
                                <span class="bg-green-900 text-green-200 px-2 py-1 rounded text-xs font-semibold">
                                    {{ $hall->seats_count }} / {{ $hall->total_seats }}
                                </span>
                            @else
                                <span class="bg-yellow-900 text-yellow-200 px-2 py-1 rounded text-xs font-semibold"
                                      title="Seat rows do not match the declared capacity">
                                    {{ $hall->seats_count }} / {{ $hall->total_seats }}
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-gray-300">{{ $hall->showtimes_count }}</td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.halls.edit', $hall) }}" class="text-primary hover:text-red-400 mr-3">Edit</a>

                            <form method="POST" action="{{ route('admin.halls.destroy', $hall) }}" class="inline"
                                  onsubmit="return confirm('Delete &quot;{{ $hall->name }}&quot;? Its seats will be removed too.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 px-4 text-center text-gray-500 italic">No halls found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
