@php
    // `old()` wins after a failed validation pass, otherwise fall back to the model.
    $value = fn ($field, $default = null) => old($field, $movie->$field ?? $default);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <label for="title" class="block text-sm text-gray-400 mb-2">Title <span class="text-primary">*</span></label>
        <input type="text" id="title" name="title" value="{{ $value('title') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('title') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm text-gray-400 mb-2">Description <span class="text-primary">*</span></label>
        <textarea id="description" name="description" rows="4" required
                  class="w-full bg-neutral text-white px-4 py-2 rounded border @error('description') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">{{ $value('description') }}</textarea>
        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="genre" class="block text-sm text-gray-400 mb-2">Genre <span class="text-primary">*</span></label>
        <input type="text" id="genre" name="genre" value="{{ $value('genre') }}" required placeholder="Action, Animation, Sci-Fi..."
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('genre') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('genre') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="language" class="block text-sm text-gray-400 mb-2">Language <span class="text-primary">*</span></label>
        <input type="text" id="language" name="language" value="{{ $value('language') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('language') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('language') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="duration" class="block text-sm text-gray-400 mb-2">Duration (minutes) <span class="text-primary">*</span></label>
        <input type="number" id="duration" name="duration" value="{{ $value('duration') }}" min="1" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('duration') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('duration') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="release_date" class="block text-sm text-gray-400 mb-2">Release Date <span class="text-primary">*</span></label>
        <input type="date" id="release_date" name="release_date" required
               value="{{ old('release_date', optional($movie->release_date)->format('Y-m-d')) }}"
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('release_date') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('release_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="rating" class="block text-sm text-gray-400 mb-2">Rating (0 - 10)</label>
        <input type="number" id="rating" name="rating" value="{{ $value('rating') }}" step="0.1" min="0" max="10"
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('rating') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('rating') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="status" class="block text-sm text-gray-400 mb-2">Status <span class="text-primary">*</span></label>
        <select id="status" name="status" required
                class="w-full bg-neutral text-white px-4 py-2 rounded border @error('status') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
            @foreach (['coming_soon' => 'Coming Soon', 'now_showing' => 'Now Showing', 'ended' => 'Ended'] as $key => $label)
                <option value="{{ $key }}" @selected($value('status', 'coming_soon') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="trailer_url" class="block text-sm text-gray-400 mb-2">Trailer URL</label>
        <input type="url" id="trailer_url" name="trailer_url" value="{{ $value('trailer_url') }}" placeholder="https://youtube.com/watch?v=..."
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('trailer_url') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('trailer_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="poster_file" class="block text-sm text-gray-400 mb-2">Upload Poster</label>
        <input type="file" id="poster_file" name="poster_file" accept="image/*"
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('poster_file') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-primary file:text-white">
        <p class="text-gray-500 text-xs mt-1">JPG, PNG or WEBP, max 2 MB. Replaces the poster path below.</p>
        @error('poster_file') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="poster" class="block text-sm text-gray-400 mb-2">Poster Path / URL</label>
        <input type="text" id="poster" name="poster" value="{{ $value('poster') }}" placeholder="posters/example.jpg"
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('poster') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('poster') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror

        @if ($movie->poster)
            <p class="text-gray-500 text-xs mt-2">Current: {{ $movie->poster }}</p>
        @endif
    </div>

</div>

<div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
    <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        <i class="fas fa-save mr-2"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.movies.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
        Cancel
    </a>
</div>
