@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.showtimes.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Showtimes
        </a>
        <h1 class="text-4xl font-bold mt-3">Edit Showtime</h1>
        <p class="text-gray-400 mt-2">
            {{ $showtime->movie->title ?? '' }} &middot;
            {{ \Illuminate\Support\Carbon::parse($showtime->start_time)->format('M d, Y H:i') }}
        </p>
    </div>

    @if ($showtime->bookings()->exists())
        <div class="bg-yellow-900/40 border border-yellow-700 text-yellow-100 px-4 py-3 rounded-lg mb-6 text-sm">
            <i class="fas fa-triangle-exclamation mr-2"></i>
            This showtime has bookings, so it cannot be moved to a different hall.
        </div>
    @endif

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.showtimes.update', $showtime) }}">
            @csrf
            @method('PUT')
            @include('admin.showtimes._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</div>

@endsection
