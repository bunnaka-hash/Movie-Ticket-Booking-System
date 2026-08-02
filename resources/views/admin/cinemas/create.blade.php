@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.cinemas.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Cinemas
        </a>
        <h1 class="text-4xl font-bold mt-3">Add Cinema</h1>
        <p class="text-gray-400 mt-2">Create a new cinema branch</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.cinemas.store') }}">
            @csrf
            @include('admin.cinemas._form', ['submitLabel' => 'Create Cinema'])
        </form>
    </div>
</div>

@endsection
