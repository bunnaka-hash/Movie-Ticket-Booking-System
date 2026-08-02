@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.halls.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Halls
        </a>
        <h1 class="text-4xl font-bold mt-3">Add Hall</h1>
        <p class="text-gray-400 mt-2">Create a hall and generate its seat map</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.halls.store') }}">
            @csrf
            @include('admin.halls._form', ['submitLabel' => 'Create Hall'])
        </form>
    </div>
</div>

@endsection
