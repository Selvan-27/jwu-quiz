<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::where('is_admin',0)->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
            'is_admin' => 'boolean',
        ]);

        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        
        // Ensure is_admin is present, default to false if not checked
        $validated['is_admin'] = $request->has('is_admin');

        \App\Models\User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:4|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle checkbox for boolean
        $validated['is_admin'] = $request->has('is_admin');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
      public function history(\App\Models\User $user)
    {
        $attempts = $user->quizAttempts()
            ->with(['quiz'])
            ->latest()
            ->paginate(15);
            
        return view('admin.users.history', compact('user', 'attempts'));
    }
}
