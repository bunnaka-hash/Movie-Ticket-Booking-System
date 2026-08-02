@extends('layouts.admin')

@section('content')

<div>
    <h1 class="text-4xl font-bold mb-2">Welcome, Admin 👋</h1>
    <p class="text-gray-400 mb-8">Here's your dashboard overview</p>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

        <!-- Movies Card -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Movies</p>
                    <p class="text-4xl font-bold text-white">25</p>
                    <p class="text-xs text-gray-500 mt-2">+3 this month</p>
                </div>
                <i class="fas fa-film text-primary text-5xl opacity-20"></i>
            </div>
        </div>

        <!-- Cinemas Card -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Cinemas</p>
                    <p class="text-4xl font-bold text-white">8</p>
                    <p class="text-xs text-gray-500 mt-2">+1 this month</p>
                </div>
                <i class="fas fa-building text-primary text-5xl opacity-20"></i>
            </div>
        </div>

        <!-- Showtimes Card -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Showtimes</p>
                    <p class="text-4xl font-bold text-white">156</p>
                    <p class="text-xs text-gray-500 mt-2">+12 this week</p>
                </div>
                <i class="fas fa-calendar-alt text-primary text-5xl opacity-20"></i>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800 hover:border-primary transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-2">Total Bookings</p>
                    <p class="text-4xl font-bold text-white">342</p>
                    <p class="text-xs text-green-400 mt-2">+45 this week</p>
                </div>
                <i class="fas fa-ticket-alt text-primary text-5xl opacity-20"></i>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-secondary p-6 rounded-xl border border-gray-800">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                Recent Bookings
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-neutral rounded-lg">
                    <div>
                        <p class="text-white font-semibold">John Doe</p>
                        <p class="text-gray-400 text-sm">Avengers: Endgame</p>
                    </div>
                    <div class="text-right">
                        <p class="text-primary font-bold">$48.50</p>
                        <p class="text-gray-400 text-xs">Today</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-neutral rounded-lg">
                    <div>
                        <p class="text-white font-semibold">Jane Smith</p>
                        <p class="text-gray-400 text-sm">Inside Out 2</p>
                    </div>
                    <div class="text-right">
                        <p class="text-primary font-bold">$37.00</p>
                        <p class="text-gray-400 text-xs">Yesterday</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-neutral rounded-lg">
                    <div>
                        <p class="text-white font-semibold">Mike Johnson</p>
                        <p class="text-gray-400 text-sm">The Dark Knight</p>
                    </div>
                    <div class="text-right">
                        <p class="text-primary font-bold">$52.00</p>
                        <p class="text-gray-400 text-xs">2 days ago</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-secondary p-6 rounded-xl border border-gray-800">
            <h2 class="text-xl font-bold mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.movies.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Movie
                </a>
                <a href="{{ route('admin.cinemas.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Cinema
                </a>
                <a href="{{ route('admin.showtimes.index') }}" class="block p-3 bg-primary hover:bg-red-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-plus mr-2"></i> Add Showtime
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block p-3 bg-tertiary hover:bg-blue-700 text-white rounded-lg text-center font-semibold transition">
                    <i class="fas fa-list mr-2"></i> View All Bookings
                </a>
            </div>
        </div>

    </div>
</div>

@endsection


<div class="flex justify-between mb-5">


<h2 class="text-xl font-bold">

Upcoming Showtimes

</h2>


<button
class="bg-cinema-primary px-5 py-2 rounded-lg">

+ Add Showtime

</button>


</div>





<table class="w-full text-left">


<thead class="border-b border-gray-700">


<tr>

<th class="p-3">
Movie
</th>

<th>
Hall
</th>

<th>
Date
</th>

<th>
Time
</th>

</tr>


</thead>



<tbody>


<tr class="border-b border-gray-700">


<td class="p-3">
Inside Out 2
</td>


<td>
Hall 1
</td>


<td>
03 Aug 2026
</td>


<td>
10:00
</td>


</tr>



<tr>


<td class="p-3">
Deadpool
</td>


<td>
VIP Hall
</td>


<td>
03 Aug 2026
</td>


<td>
19:00
</td>


</tr>



</tbody>


</table>



</div>



@endsection