@php
    $value = fn ($field) => old($field, $showtime->$field ?? null);

    $startValue = old('start_time', $showtime->start_time
        ? \Illuminate\Support\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i')
        : null);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label for="movie_id" class="block text-sm text-gray-400 mb-2">Movie <span class="text-primary">*</span></label>
        <select id="movie_id" name="movie_id" required
                class="w-full bg-neutral text-white px-4 py-2 rounded border @error('movie_id') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
            <option value="">Select a movie</option>
            @foreach ($movies as $movie)
                <option value="{{ $movie->id }}" data-duration="{{ $movie->duration }}"
                        @selected((int) $value('movie_id') === $movie->id)>
                    {{ $movie->title }} ({{ $movie->duration }} min)
                </option>
            @endforeach
        </select>
        @error('movie_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="hall_id" class="block text-sm text-gray-400 mb-2">Hall <span class="text-primary">*</span></label>
        <select id="hall_id" name="hall_id" required
                class="w-full bg-neutral text-white px-4 py-2 rounded border @error('hall_id') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
            <option value="">Select a hall</option>
            @foreach ($halls->groupBy(fn ($hall) => $hall->cinema->name ?? 'Unassigned') as $cinemaName => $cinemaHalls)
                <optgroup label="{{ $cinemaName }}">
                    @foreach ($cinemaHalls as $hall)
                        <option value="{{ $hall->id }}" @selected((int) $value('hall_id') === $hall->id)>
                            {{ $hall->name }} ({{ $hall->total_seats }} seats)
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @error('hall_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="start_time" class="block text-sm text-gray-400 mb-2">Start Time <span class="text-primary">*</span></label>
        <input type="datetime-local" id="start_time" name="start_time" value="{{ $startValue }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('start_time') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        <p class="text-gray-500 text-xs mt-1">
            Ends at <span id="end-preview" class="text-gray-300">—</span>, calculated from the movie's duration.
        </p>
        @error('start_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        @error('end_time') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="price" class="block text-sm text-gray-400 mb-2">Ticket Price ($) <span class="text-primary">*</span></label>
        <input type="number" id="price" name="price" value="{{ $value('price') }}" step="0.01" min="0" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('price') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

</div>

<div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
    <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        <i class="fas fa-save mr-2"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.showtimes.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
        Cancel
    </a>
</div>

<script>
    // Preview only - the end time is always recalculated server side.
    (function () {
        const movieSelect = document.getElementById('movie_id');
        const startInput = document.getElementById('start_time');
        const preview = document.getElementById('end-preview');

        function updatePreview() {
            const duration = parseInt(movieSelect.selectedOptions[0]?.dataset.duration || '0', 10);

            if (!duration || !startInput.value) {
                preview.textContent = '—';
                return;
            }

            const end = new Date(startInput.value);
            end.setMinutes(end.getMinutes() + duration);
            preview.textContent = end.toLocaleString([], {
                month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit',
            });
        }

        movieSelect.addEventListener('change', updatePreview);
        startInput.addEventListener('change', updatePreview);
        updatePreview();
    })();
</script>
