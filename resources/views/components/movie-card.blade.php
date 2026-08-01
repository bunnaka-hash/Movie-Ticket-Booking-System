<div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">

    <img
        src="https://placehold.co/400x600?text=Movie"
        class="w-full h-80 object-cover"
        alt="{{ $movie->title }}">

    <div class="p-4">

        <h2 class="font-bold text-lg">
            {{ $movie->title }}
        </h2>

        <p class="text-gray-500 mt-2">
            {{ $movie->genre }}
        </p>

        <p class="mt-2">
            ⭐ {{ $movie->rating }}
        </p>

        <a
            href="{{ route('movies.show',$movie) }}"
            class="block mt-4 text-center bg-red-600 text-white py-2 rounded hover:bg-red-700">

            View Details

        </a>

    </div>

</div>