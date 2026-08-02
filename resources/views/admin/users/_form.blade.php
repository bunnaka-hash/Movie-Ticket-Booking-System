@php
    $value = fn ($field) => old($field, $user->$field ?? null);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label for="name" class="block text-sm text-gray-400 mb-2">Name <span class="text-primary">*</span></label>
        <input type="text" id="name" name="name" value="{{ $value('name') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('name') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm text-gray-400 mb-2">Email <span class="text-primary">*</span></label>
        <input type="email" id="email" name="email" value="{{ $value('email') }}" required
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('email') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm text-gray-400 mb-2">Phone</label>
        <input type="text" id="phone" name="phone" value="{{ $value('phone') }}"
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('phone') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="role" class="block text-sm text-gray-400 mb-2">Role <span class="text-primary">*</span></label>
        <select id="role" name="role" required
                class="w-full bg-neutral text-white px-4 py-2 rounded border @error('role') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
            @foreach (['customer' => 'Customer', 'staff' => 'Staff', 'admin' => 'Admin'] as $key => $label)
                <option value="{{ $key }}" @selected($value('role') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @if ($user->exists && $user->id === auth()->id())
            <p class="text-gray-500 text-xs mt-1">This is your own account — you cannot remove your admin role.</p>
        @endif
        @error('role') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password" class="block text-sm text-gray-400 mb-2">
            Password @unless ($user->exists) <span class="text-primary">*</span> @endunless
        </label>
        <input type="password" id="password" name="password" autocomplete="new-password" @required(! $user->exists)
               class="w-full bg-neutral text-white px-4 py-2 rounded border @error('password') border-red-600 @else border-gray-700 @enderror focus:border-primary focus:outline-none">
        @if ($user->exists)
            <p class="text-gray-500 text-xs mt-1">Leave blank to keep the current password.</p>
        @endif
        @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm text-gray-400 mb-2">
            Confirm Password @unless ($user->exists) <span class="text-primary">*</span> @endunless
        </label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" @required(! $user->exists)
               class="w-full bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
    </div>

</div>

<div class="flex gap-3 mt-8 pt-6 border-t border-gray-700">
    <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        <i class="fas fa-save mr-2"></i> {{ $submitLabel }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="bg-secondary hover:bg-neutral text-gray-300 px-6 py-3 rounded-lg font-semibold border border-gray-700 transition">
        Cancel
    </a>
</div>
