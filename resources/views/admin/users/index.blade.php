@extends('layouts.admin')

@section('content')

<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">Users Management</h1>
            <p class="text-gray-400 mt-2">{{ $users->total() }} registered users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-primary hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
            <i class="fas fa-plus mr-2"></i> Add User
        </a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" class="bg-secondary p-4 rounded-xl border border-gray-800 mb-6 flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by name or email..."
               class="flex-1 bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
        <select name="role" class="bg-neutral text-white px-4 py-2 rounded border border-gray-700 focus:border-primary focus:outline-none">
            <option value="">All Roles</option>
            @foreach (['admin' => 'Admin', 'staff' => 'Staff', 'customer' => 'Customer'] as $value => $label)
                <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary hover:bg-red-700 text-white px-6 py-2 rounded font-semibold transition">
            Filter
        </button>
    </form>

    <!-- Users Table -->
    <div class="bg-secondary p-6 rounded-xl border border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="text-left py-4 px-4 text-gray-400">Name</th>
                    <th class="text-left py-4 px-4 text-gray-400">Email</th>
                    <th class="text-left py-4 px-4 text-gray-400">Phone</th>
                    <th class="text-left py-4 px-4 text-gray-400">Role</th>
                    <th class="text-left py-4 px-4 text-gray-400">Bookings</th>
                    <th class="text-center py-4 px-4 text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-gray-800 hover:bg-neutral transition">
                        <td class="py-4 px-4 text-white font-semibold">{{ $user->name }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $user->email }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $user->phone ?? '—' }}</td>
                        <td class="py-4 px-4">
                            @php
                                $badge = match ($user->role) {
                                    'admin' => 'bg-red-900 text-red-200',
                                    'staff' => 'bg-purple-900 text-purple-200',
                                    default => 'bg-blue-900 text-blue-200',
                                };
                            @endphp
                            <span class="{{ $badge }} px-3 py-1 rounded text-xs font-semibold">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-gray-300">{{ $user->bookings_count }}</td>
                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-primary hover:text-red-400 mr-3">Edit</a>

                            @if ($user->id === auth()->id())
                                <span class="text-gray-600" title="You cannot delete your own account">Delete</span>
                            @else
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                      onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 px-4 text-center text-gray-500 italic">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
