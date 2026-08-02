@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Movies
        </a>
        <h1 class="text-4xl font-bold mt-3">Edit Movie</h1>
        <p class="text-gray-400 mt-2">{{ $movie->title }}</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.movies._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</div>

@endsection
