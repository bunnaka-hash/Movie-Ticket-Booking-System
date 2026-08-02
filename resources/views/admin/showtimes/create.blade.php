@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.showtimes.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Showtimes
        </a>
        <h1 class="text-4xl font-bold mt-3">Add Showtime</h1>
        <p class="text-gray-400 mt-2">Schedule a movie in a hall</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.showtimes.store') }}">
            @csrf
            @include('admin.showtimes._form', ['submitLabel' => 'Create Showtime'])
        </form>
    </div>
</div>

@endsection
