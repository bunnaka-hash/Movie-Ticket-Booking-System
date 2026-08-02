@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.halls.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Halls
        </a>
        <h1 class="text-4xl font-bold mt-3">Edit Hall</h1>
        <p class="text-gray-400 mt-2">{{ $hall->cinema->name ?? '' }} &middot; {{ $hall->name }}</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.halls.update', $hall) }}">
            @csrf
            @method('PUT')
            @include('admin.halls._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</div>

@endsection
