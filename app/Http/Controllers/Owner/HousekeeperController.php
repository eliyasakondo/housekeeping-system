<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HousekeeperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    /**
     * Display a listing of housekeepers for the owner.
     */
    public function index()
    {
        $housekeepers = User::where('role', 'housekeeper')
            ->where('owner_id', auth()->id())
            ->paginate(10);

        return view('owner.housekeepers.index', compact('housekeepers'));
    }

    /**
     * Show the form for creating a new housekeeper.
     */
    public function create()
    {
        return view('owner.housekeepers.create');
    }

    /**
     * Store a newly created housekeeper in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'housekeeper',
            'owner_id' => auth()->id(),
        ]);

        return redirect()->route('owner.housekeepers.index')
            ->with('success', 'Housekeeper added successfully.');
    }

    /**
     * Show the form for editing the specified housekeeper.
     */
    public function edit(User $housekeeper)
    {
        // Verify this housekeeper belongs to the authenticated owner
        if ($housekeeper->owner_id !== auth()->id() || $housekeeper->role !== 'housekeeper') {
            abort(403);
        }

        return view('owner.housekeepers.edit', compact('housekeeper'));
    }

    /**
     * Update the specified housekeeper in storage.
     */
    public function update(Request $request, User $housekeeper)
    {
        // Verify this housekeeper belongs to the authenticated owner
        if ($housekeeper->owner_id !== auth()->id() || $housekeeper->role !== 'housekeeper') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $housekeeper->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $housekeeper->name = $validated['name'];
        $housekeeper->email = $validated['email'];
        $housekeeper->phone = $validated['phone'];

        if ($request->filled('password')) {
            $housekeeper->password = Hash::make($validated['password']);
        }

        $housekeeper->save();

        return redirect()->route('owner.housekeepers.index')
            ->with('success', 'Housekeeper updated successfully.');
    }

    /**
     * Remove the specified housekeeper from storage.
     */
    public function destroy(User $housekeeper)
    {
        // Verify this housekeeper belongs to the authenticated owner
        if ($housekeeper->owner_id !== auth()->id() || $housekeeper->role !== 'housekeeper') {
            abort(403);
        }

        // Check if housekeeper has any pending/in-progress checklists
        $activeChecklists = $housekeeper->checklists()
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        if ($activeChecklists > 0) {
            return back()->with('error', 'Cannot delete housekeeper with active assignments. Please complete or reassign their checklists first.');
        }

        $housekeeper->delete();

        return redirect()->route('owner.housekeepers.index')
            ->with('success', 'Housekeeper removed successfully.');
    }
}
