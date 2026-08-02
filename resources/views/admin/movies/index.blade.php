@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Movies Management</h1>
            <p class="text-gray-400 mt-2">Manage all movies in your system</p>
        </div>
        <a href="#" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add Movie
        </a>
    </div>

    <!-- Movies Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Title</th>
                    <th class="text-left py-4 px-4 text-gray-400">Genre</th>
                    <th class="text-left py-4 px-4 text-gray-400">Duration</th>
                    <th class="text-left py-4 px-4 text-gray-400">Rating</th>
                    <th class="text-left py-4 px-4 text-gray-400">Status</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Avengers: Endgame</td>
                    <td class="py-4 px-4 text-gray-300">Action, Sci-Fi</td>
                    <td class="py-4 px-4 text-gray-300">181 min</td>
                    <td class="py-4 px-4">
                        <span class="flex items-center gap-1 text-yellow-400">
                            <i class="fas fa-star"></i> 8.4
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <span class="bg-green-900 text-green-200 px-3 py-1 rounded text-xs font-semibold">Now Showing</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400 mr-3">Edit</a>
                        <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                    </td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Inside Out 2</td>
                    <td class="py-4 px-4 text-gray-300">Animation</td>
                    <td class="py-4 px-4 text-gray-300">96 min</td>
                    <td class="py-4 px-4">
                        <span class="flex items-center gap-1 text-yellow-400">
                            <i class="fas fa-star"></i> 7.8
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <span class="bg-green-900 text-green-200 px-3 py-1 rounded text-xs font-semibold">Now Showing</span>
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
