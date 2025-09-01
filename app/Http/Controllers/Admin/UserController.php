<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with advanced filtering
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->get('date_to'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Admin created users are auto-verified

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['bids', 'managedAuctions', 'wonAuctions']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot delete your own account.');
        }

        // Soft delete approach - just mark as inactive
        $user->update([
            'status' => 'inactive',
            'admin_notes' => 'Account deactivated by admin on ' . now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User account deactivated successfully.');
    }

    /**
     * Suspend user
     */
    public function suspend(Request $request, User $user)
    {
        $reason = $request->input('reason', 'Suspended by admin');
        $user->suspend($reason);

        return redirect()->back()
                        ->with('success', 'User suspended successfully.');
    }

    /**
     * Activate user
     */
    public function activate(User $user)
    {
        $user->activate();

        return redirect()->back()
                        ->with('success', 'User activated successfully.');
    }
}
