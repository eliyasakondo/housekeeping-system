<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of all properties
     */
    public function index(Request $request)
    {
        $query = Property::with('owner');

        // Filter by owner
        if ($request->filled('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }

        // Search by property name or address
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->withCount(['rooms', 'checklists'])->orderBy('name')->paginate(20);
        
        // Get all owners for filter dropdown
        $owners = User::where('role', 'owner')->orderBy('name')->get();

        return view('admin.properties.index', compact('properties', 'owners'));
    }

    /**
     * Show the form for creating a new property
     */
    public function create()
    {
        $owners = User::where('role', 'owner')->orderBy('name')->get();
        return view('admin.properties.create', compact('owners'));
    }

    /**
     * Store a newly created property
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $property = Property::create($validated);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified property with details
     */
    public function show(Property $property)
    {
        $property->load([
            'owner',
            'rooms',
            'checklists.housekeeper',
            'checklists' => function($query) {
                $query->latest()->take(10);
            }
        ]);

        // Get checklist statistics
        $stats = [
            'total_checklists' => $property->checklists()->count(),
            'pending_checklists' => $property->checklists()->where('status', 'pending')->count(),
            'in_progress_checklists' => $property->checklists()->where('status', 'in_progress')->count(),
            'completed_checklists' => $property->checklists()->where('status', 'completed')->count(),
            'total_rooms' => $property->rooms()->count(),
        ];

        return view('admin.properties.show', compact('property', 'stats'));
    }

    /**
     * Show the form for editing the property
     */
    public function edit(Property $property)
    {
        $owners = User::where('role', 'owner')->orderBy('name')->get();
        return view('admin.properties.edit', compact('property', 'owners'));
    }

    /**
     * Update the specified property
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|integer|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $property->update($validated);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified property
     */
    public function destroy(Property $property)
    {
        // Check if property has any checklists
        if ($property->checklists()->count() > 0) {
            return back()->with('error', 'Cannot delete property with existing checklists. Please delete checklists first.');
        }

        // Delete all rooms associated with this property
        $property->rooms()->delete();

        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property and its rooms deleted successfully!');
    }
}
