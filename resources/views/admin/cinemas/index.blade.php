@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Cinemas Management</h1>
            <p class="text-gray-400 mt-2">Manage all cinema branches</p>
        </div>
        <a href="#" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Cinema
        </a>
    </div>

    <!-- Cinemas Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <h3 class="text-lg font-bold text-white mb-2">Grand Cinema Plaza</h3>
            <p class="text-gray-400 text-sm mb-4">452 Cinema Blvd, Arts District</p>
            <div class="flex items-center gap-4 mb-4">
                <span class="text-sm text-gray-300"><i class="fas fa-chair text-primary mr-2"></i>480 Seats</span>
                <span class="text-sm text-gray-300"><i class="fas fa-door-open text-primary mr-2"></i>6 Halls</span>
            </div>
            <div class="flex gap-2 pt-4 border-t border-gray-700">
                <a href="#" class="flex-1 py-2 bg-primary hover:bg-red-700 text-white text-center rounded font-semibold text-sm transition">Edit</a>
                <a href="#" class="flex-1 py-2 bg-red-900 hover:bg-red-800 text-white text-center rounded font-semibold text-sm transition">Delete</a>
            </div>
        </div>

        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <h3 class="text-lg font-bold text-white mb-2">Luxury Hall & Suites</h3>
            <p class="text-gray-400 text-sm mb-4">88 Velvet Road, Downtown Core</p>
            <div class="flex items-center gap-4 mb-4">
                <span class="text-sm text-gray-300"><i class="fas fa-chair text-primary mr-2"></i>320 Seats</span>
                <span class="text-sm text-gray-300"><i class="fas fa-door-open text-primary mr-2"></i>4 Halls</span>
            </div>
            <div class="flex gap-2 pt-4 border-t border-gray-700">
                <a href="#" class="flex-1 py-2 bg-primary hover:bg-red-700 text-white text-center rounded font-semibold text-sm transition">Edit</a>
                <a href="#" class="flex-1 py-2 bg-red-900 hover:bg-red-800 text-white text-center rounded font-semibold text-sm transition">Delete</a>
            </div>
        </div>

        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <h3 class="text-lg font-bold text-white mb-2">The Orion Premium</h3>
            <p class="text-gray-400 text-sm mb-4">123 Premium Ave, Uptown</p>
            <div class="flex items-center gap-4 mb-4">
                <span class="text-sm text-gray-300"><i class="fas fa-chair text-primary mr-2"></i>560 Seats</span>
                <span class="text-sm text-gray-300"><i class="fas fa-door-open text-primary mr-2"></i>8 Halls</span>
            </div>
            <div class="flex gap-2 pt-4 border-t border-gray-700">
                <a href="#" class="flex-1 py-2 bg-primary hover:bg-red-700 text-white text-center rounded font-semibold text-sm transition">Edit</a>
                <a href="#" class="flex-1 py-2 bg-red-900 hover:bg-red-800 text-white text-center rounded font-semibold text-sm transition">Delete</a>
            </div>
        </div>
    </div>
</div>

@endsection
