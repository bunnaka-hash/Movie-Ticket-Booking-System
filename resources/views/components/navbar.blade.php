<nav class="bg-gray-900 text-white shadow">

    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-center h-16">

            <div>

                <a href="/"
                   class="text-xl font-bold">

                    🎬 Movie Ticket

                </a>

            </div>

            <div class="space-x-6">

                <a href="/">Home</a>

                <a href="/movies">Movies</a>

                <a href="#">Cinemas</a>

                <a href="#">Bookings</a>

            </div>

            <div>

                @auth

                    <a href="/dashboard"
                       class="bg-blue-600 px-4 py-2 rounded">

                        Dashboard

                    </a>

                @else

                    <a href="/login"
                       class="bg-red-600 px-4 py-2 rounded">

                        Login

                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>