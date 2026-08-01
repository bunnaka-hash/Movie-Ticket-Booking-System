<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Movie Ticket Booking')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-navbar />

    <main class="flex-1">

        @yield('content')

    </main>

    <x-footer />

</body>

</html>