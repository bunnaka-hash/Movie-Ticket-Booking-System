@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Movies
        </a>
        <h1 class="text-4xl font-bold mt-3">Add Movie</h1>
        <p class="text-gray-400 mt-2">Create a new movie in the catalogue</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.movies._form', ['submitLabel' => 'Create Movie'])
        </form>
    </div>
</div>

@endsection
