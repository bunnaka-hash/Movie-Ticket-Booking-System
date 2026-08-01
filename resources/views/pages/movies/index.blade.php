@extends('layouts.app')

@section('title','Movies')

@section('content')

<div class="max-w-7xl mx-auto py-10">

    <h1 class="text-4xl font-bold mb-8">

        Now Showing

    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        @foreach($movies as $movie)

            <x-movie-card :movie="$movie"/>

        @endforeach

    </div>

    <div class="mt-10">

        {{ $movies->links() }}

    </div>

</div>

@endsection