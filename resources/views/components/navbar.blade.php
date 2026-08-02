<nav class="bg-neutral border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="bg-primary rounded p-1">
                    <i class="fas fa-film text-white text-lg"></i>
                </div>
                <a href="/" class="text-xl font-bold text-white hover:text-primary transition">
                    CINEMA PREMIUM
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-gray-300 hover:text-primary transition font-medium">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="/movies" class="text-gray-300 hover:text-primary transition font-medium">
                    <i class="fas fa-film mr-2"></i>Cinemas
                </a>
                <a href="/movies" class="text-gray-300 hover:text-primary transition font-medium">
                    <i class="fas fa-ticket mr-2"></i>Offers
                </a>
                <a href="#" class="text-gray-300 hover:text-primary transition font-medium">
                    <i class="fas fa-clock mr-2"></i>Schedule
                </a>
            </div>

            <!-- Right Icons -->
            <div class="hidden md:flex items-center gap-6">
                <div class="relative">
                    <input type="text" placeholder="Search movies..." 
                        class="bg-secondary px-4 py-2 rounded text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary w-48">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
                </div>
                @auth
                    <div class="flex items-center gap-4">
                        <a href="/profile" class="text-gray-300 hover:text-primary transition text-lg">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-300 hover:text-primary transition text-lg">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-primary px-6 py-2 rounded hover:bg-red-700 transition font-medium">
                        Sign In
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white text-xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-800 py-4 space-y-3">
            <a href="/" class="block px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                <i class="fas fa-home mr-2"></i>Home
            </a>
            <a href="/movies" class="block px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                <i class="fas fa-film mr-2"></i>Cinemas
            </a>
            <a href="/movies" class="block px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                <i class="fas fa-ticket mr-2"></i>Offers
            </a>
            <a href="#" class="block px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                <i class="fas fa-clock mr-2"></i>Schedule
            </a>
            @auth
                <a href="/profile" class="block px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                    <i class="fas fa-user-circle mr-2"></i>Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:text-primary hover:bg-secondary rounded transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 bg-primary text-white rounded hover:bg-red-700 transition text-center font-medium">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</nav>