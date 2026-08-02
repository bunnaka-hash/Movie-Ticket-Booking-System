@extends('layouts.admin')

@section('content')

<div>
    <div class="mb-8">
        <h1 class="text-4xl font-bold">Bookings Management</h1>
        <p class="text-gray-400 mt-2">View and manage all ticket bookings</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <input type="text" placeholder="Search by booking ID or customer..." class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <select class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option>All Status</option>
            <option>Confirmed</option>
            <option>Pending</option>
            <option>Cancelled</option>
        </select>
    </div>

    <!-- Bookings Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Booking ID</th>
                    <th class="text-left py-4 px-4 text-gray-400">Customer</th>
                    <th class="text-left py-4 px-4 text-gray-400">Movie</th>
                    <th class="text-left py-4 px-4 text-gray-400">Date & Time</th>
                    <th class="text-left py-4 px-4 text-gray-400">Seats</th>
                    <th class="text-left py-4 px-4 text-gray-400">Amount</th>
                    <th class="text-left py-4 px-4 text-gray-400">Status</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">#BK001234</td>
                    <td class="py-4 px-4 text-gray-300">John Doe</td>
                    <td class="py-4 px-4 text-gray-300">Avengers: Endgame</td>
                    <td class="py-4 px-4 text-gray-300">Aug 02, 20:45</td>
                    <td class="py-4 px-4 text-gray-300">A1, A2</td>
                    <td class="py-4 px-4 text-primary font-semibold">$48.50</td>
                    <td class="py-4 px-4">
                        <span class="bg-green-900 text-green-200 px-3 py-1 rounded text-xs font-semibold">Confirmed</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400">View</a>
                    </td>
                </tr>
                <tr class="border-b border-gray-800 hover:bg-neutral transition">
                    <td class="py-4 px-4 text-white font-semibold">#BK001233</td>
                    <td class="py-4 px-4 text-gray-300">Jane Smith</td>
                    <td class="py-4 px-4 text-gray-300">Inside Out 2</td>
                    <td class="py-4 px-4 text-gray-300">Aug 03, 14:30</td>
                    <td class="py-4 px-4 text-gray-300">B5, B6, B7</td>
                    <td class="py-4 px-4 text-primary font-semibold">$37.00</td>
                    <td class="py-4 px-4">
                        <span class="bg-yellow-900 text-yellow-200 px-3 py-1 rounded text-xs font-semibold">Pending</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <a href="#" class="text-primary hover:text-red-400">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
