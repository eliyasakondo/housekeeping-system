<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    public function index()
    {
        $properties = auth()->user()->properties()->with('rooms')->get();
        return view('owner.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('owner.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|numeric|min:0',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $validated['owner_id'] = auth()->id();

        Property::create($validated);

        return redirect()->route('owner.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);
        
        // Load rooms with their tasks
        $property->load(['rooms.tasks']);
        
        // Get all available tasks (default + owner's custom tasks)
        $availableTasks = \App\Models\Task::where(function($query) {
            $query->where('is_default', true)
                  ->orWhere('property_id', null);
        })->orWhere('property_id', auth()->id())
          ->get();
        
        // Get default rooms for quick add
        $defaultRooms = \App\Models\Room::where('is_default', true)->get();
        
        return view('owner.properties.show', compact('property', 'availableTasks', 'defaultRooms'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('owner.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|numeric|min:0',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $property->update($validated);

        return redirect()->route('owner.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();

        return redirect()->route('owner.properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}
