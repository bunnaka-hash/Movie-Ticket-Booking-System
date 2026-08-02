<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cinema Admin</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>


<body class="bg-neutral text-white">


<div class="flex min-h-screen">


    <!-- Sidebar -->

    <aside class="w-64 bg-secondary p-6 border-r border-gray-800 fixed h-screen overflow-y-auto">


        <div class="mb-10">
            <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
                <i class="fas fa-film"></i> Cinema Admin
            </h1>
            <p class="text-gray-400 text-sm mt-2">{{ auth()->user()->name }}</p>
        </div>


        <nav class="space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-chart-line mr-2"></i> Dashboard
            </a>

            <a href="{{ route('admin.movies.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.movies.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-film mr-2"></i> Movies
            </a>

            <a href="{{ route('admin.cinemas.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.cinemas.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-building mr-2"></i> Cinemas
            </a>

            <a href="{{ route('admin.halls.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.halls.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-chair mr-2"></i> Halls
            </a>

            <a href="{{ route('admin.showtimes.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.showtimes.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-calendar-alt mr-2"></i> Showtimes
            </a>

            <a href="{{ route('admin.bookings.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.bookings.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-ticket-alt mr-2"></i> Bookings
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="block p-3 rounded-lg text-gray-300 hover:bg-primary hover:text-white transition
               {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-users mr-2"></i> Users
            </a>

        </nav>

        <!-- Logout -->
        <div class="absolute bottom-6 left-6 right-6">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full p-3 bg-red-600 hover:bg-red-700 rounded-lg text-white transition font-semibold">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>

    </aside>


    <!-- Content -->

    <main class="flex-1 ml-64 p-8">


        {{ $slot ?? '' }}

        @yield('content')


    </main>



</div>


</body>

</html>