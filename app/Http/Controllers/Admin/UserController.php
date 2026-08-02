<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->withCount('bookings')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create', ['user' => new User()]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        // The User model casts `password` to `hashed`, so the plain value is
        // hashed once on save - do not pre-hash it here.
        $user = User::create($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', "\"{$user->name}\" was created.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        // Blank password field means "keep the existing one".
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        // Don't let the signed-in admin lock themselves out of the panel.
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return redirect()
                ->route('admin.users.edit', $user)
                ->withInput()
                ->with('error', 'You cannot remove your own admin role.');
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "\"{$user->name}\" was updated.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return $this->refuse('You cannot delete your own account.');
        }

        // bookings.user_id cascades, and booking_details cascade off that.
        $bookingCount = $user->bookings()->count();

        if ($bookingCount > 0) {
            return $this->refuse("\"{$user->name}\" has {$bookingCount} booking(s). Delete those bookings first.");
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return $this->refuse('This is the only admin account, so it cannot be deleted.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "\"{$name}\" was deleted.");
    }

    private function refuse(string $message): RedirectResponse
    {
        return redirect()->route('admin.users.index')->with('error', $message);
    }
}
