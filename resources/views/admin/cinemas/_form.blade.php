@php
    $value = fn ($field) => old($field, $cinema->$field ?? null);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <label for="name" class="block text-sm text-gray-400 mb-2">Cinema Name <span class="text-primary">*</span></label>
        <input type="text" id="name" name="name" value="{{ $value('name') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('name') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="block text-sm text-gray-400 mb-2">Address <span class="text-primary">*</span></label>
        <input type="text" id="address" name="address" value="{{ $value('address') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('address') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="city" class="block text-sm text-gray-400 mb-2">City <span class="text-primary">*</span></label>
        <input type="text" id="city" name="city" value="{{ $value('city') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('city') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('city') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm text-gray-400 mb-2">Phone <span class="text-primary">*</span></label>
        <input type="text" id="phone" name="phone" value="{{ $value('phone') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('phone') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

</div>

<div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
    <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        <i class="fas fa-save mr-2"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.cinemas.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
        Cancel
    </a>
</div>
