<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Movie Ticket Booking')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-neutral text-white min-h-screen flex flex-col">

    <x-navbar />

    <main class="flex-1">
        @if (session('success') || session('error') || session('warning') || session('status') || $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <x-flash />
            </div>
        @endif

        @yield('content')
    </main>

    <x-footer />

</body>

</html>