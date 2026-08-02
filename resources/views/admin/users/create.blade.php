@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-primary text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
        <h1 class="text-4xl font-bold mt-3">Add User</h1>
        <p class="text-gray-400 mt-2">Create a customer, staff or admin account</p>
    </div>

    <div class="bg-secondary p-6 rounded-xl border border-gray-800">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.users._form', ['submitLabel' => 'Create User'])
        </form>
    </div>
</div>

@endsection
