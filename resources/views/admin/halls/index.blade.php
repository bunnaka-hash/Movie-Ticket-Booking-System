@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Halls Management</h1>
            <p class="text-gray-400 mt-2">Manage cinema halls and seating</p>
        </div>
        <a href="#" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
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
                    <th class="text-left py-4 px-4 text-gray-400">Format</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Hall A - IMAX</td>
                    <td class="py-4 px-4 text-gray-300">Grand Cinema Plaza</td>
                    <td class="py-4 px-4 text-gray-300">240 Seats</td>
                    <td class="py-4 px-4">
                        <span class="bg-blue-900 text-blue-200 px-2 py-1 rounded text-xs font-semibold">IMAX</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400 mr-3">Edit</a>
                        <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                    </td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Hall B - Standard</td>
                    <td class="py-4 px-4 text-gray-300">Grand Cinema Plaza</td>
                    <td class="py-4 px-4 text-gray-300">180 Seats</td>
                    <td class="py-4 px-4">
                        <span class="bg-gray-900 text-gray-200 px-2 py-1 rounded text-xs font-semibold">2D</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400 mr-3">Edit</a>
                        <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
