@extends('layouts.app')

@section('title',$movie->title)

@section('content')

<div class="max-w-5xl mx-auto py-10">

    <div class="grid md:grid-cols-2 gap-10">

        <img
            src="https://placehold.co/500x700?text=Poster"
            class="rounded-xl">

        <div>

            <h1 class="text-4xl font-bold">

                {{ $movie->title }}

            </h1>

            <p class="mt-4">

                {{ $movie->description }}

            </p>

            <p class="mt-4">

                Genre :
                {{ $movie->genre }}

            </p>

            <p>

                Duration :
                {{ $movie->duration }} mins

            </p>

            <p>

                Rating :
                ⭐ {{ $movie->rating }}

            </p>

            <button
                class="mt-8 bg-red-600 text-white px-6 py-3 rounded">

                Book Ticket

            </button>

        </div>

    </div>

</div>

@endsection