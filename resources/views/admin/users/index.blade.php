@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Users Management</h1>
            <p class="text-gray-400 mt-2">Manage all registered users</p>
        </div>
        <a href="#" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add User
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <input type="text" placeholder="Search by name or email..." class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <select class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option>All Roles</option>
            <option>Admin</option>
            <option>Customer</option>
        </select>
    </div>

    <!-- Users Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Name</th>
                    <th class="text-left py-4 px-4 text-gray-400">Email</th>
                    <th class="text-left py-4 px-4 text-gray-400">Phone</th>
                    <th class="text-left py-4 px-4 text-gray-400">Role</th>
                    <th class="text-left py-4 px-4 text-gray-400">Bookings</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">John Doe</td>
                    <td class="py-4 px-4 text-gray-300">john@example.com</td>
                    <td class="py-4 px-4 text-gray-300">+1 (555) 123-4567</td>
                    <td class="py-4 px-4">
                        <span class="bg-blue-900 text-blue-200 px-3 py-1 rounded text-xs font-semibold">Customer</span>
                    </td>
                    <td class="py-4 px-4 text-gray-300">12</td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400 mr-3">Edit</a>
                        <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                    </td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Admin User</td>
                    <td class="py-4 px-4 text-gray-300">admin@cinema.com</td>
                    <td class="py-4 px-4 text-gray-300">+1 (555) 987-6543</td>
                    <td class="py-4 px-4">
                        <span class="bg-red-900 text-red-200 px-3 py-1 rounded text-xs font-semibold">Admin</span>
                    </td>
                    <td class="py-4 px-4 text-gray-300">0</td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400 mr-3">Edit</a>
                        <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                    </td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">Jane Smith</td>
                    <td class="py-4 px-4 text-gray-300">jane@example.com</td>
                    <td class="py-4 px-4 text-gray-300">+1 (555) 456-7890</td>
                    <td class="py-4 px-4">
                        <span class="bg-blue-900 text-blue-200 px-3 py-1 rounded text-xs font-semibold">Customer</span>
                    </td>
                    <td class="py-4 px-4 text-gray-300">8</td>
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
