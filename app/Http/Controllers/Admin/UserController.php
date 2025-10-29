<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $users = User::with('owner')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Get all owners for the dropdown when creating a housekeeper
        $owners = User::where('role', 'owner')->orderBy('name')->get();
        return view('admin.users.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,owner,housekeeper',
            'phone' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
        ]);

        // If role is housekeeper, owner_id is required
        if ($validated['role'] === 'housekeeper') {
            $request->validate([
                'owner_id' => 'required|exists:users,id',
            ]);
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        // Get all owners for the dropdown when editing a housekeeper
        $owners = User::where('role', 'owner')->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'owners'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,owner,housekeeper',
            'phone' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
        ]);

        // If role is housekeeper, owner_id is required
        if ($validated['role'] === 'housekeeper') {
            $request->validate([
                'owner_id' => 'required|exists:users,id',
            ]);
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
