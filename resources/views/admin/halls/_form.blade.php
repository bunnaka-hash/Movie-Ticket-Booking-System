@php
    $value = fn ($field) => old($field, $hall->$field ?? null);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label for="cinema_id" class="block text-sm text-gray-400 mb-2">Cinema <span class="text-primary">*</span></label>
        <select id="cinema_id" name="cinema_id" required
                class="w-full bg-neutral text-white px-4 py-2 rounded border @error('cinema_id') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
            <option value="">Select a cinema</option>
            @foreach ($cinemas as $cinema)
                <option value="{{ $cinema->id }}" @selected((int) $value('cinema_id') === $cinema->id)>{{ $cinema->name }}</option>
            @endforeach
        </select>
        @error('cinema_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="name" class="block text-sm text-gray-400 mb-2">Hall Name <span class="text-primary">*</span></label>
        <input type="text" id="name" name="name" value="{{ $value('name') }}" required placeholder="Hall 1, VIP Hall..."
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('name') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        <p class="text-gray-500 text-xs mt-1">A name containing "VIP" makes every seat a VIP seat.</p>
        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="total_seats" class="block text-sm text-gray-400 mb-2">Capacity (seats) <span class="text-primary">*</span></label>
        <input type="number" id="total_seats" name="total_seats" value="{{ $value('total_seats') }}" min="1" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('total_seats') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        <p class="text-gray-500 text-xs mt-1">
            The seat map is generated automatically from this number (rows A, B, C… of 8–14 seats).
            @if ($hall->exists)
                Changing it rebuilds the seat map, which is only allowed while no seat in this hall is booked.
            @endif
        </p>
        @error('total_seats') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

</div>

<div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
    <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        <i class="fas fa-save mr-2"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.halls.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
        Cancel
    </a>
</div>
