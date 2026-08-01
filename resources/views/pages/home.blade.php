@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="relative bg-gray-900 text-white">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-32">

        <h1 class="text-6xl font-bold leading-tight">

            Experience Movies<br>

            Like Never Before

        </h1>

        <p class="mt-6 text-xl text-gray-300 max-w-2xl">

            Browse the latest movies, choose your favorite seats,
            and book tickets online in seconds.

        </p>

        <a href="{{ route('movies.index') }}"
           class="inline-block mt-8 bg-red-600 hover:bg-red-700 px-8 py-4 rounded-lg text-lg font-semibold">

            Browse Movies

        </a>

    </div>

</section>

@endsection