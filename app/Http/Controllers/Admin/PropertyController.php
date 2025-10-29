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
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'latitude.required' => 'GPS Latitude is required for housekeeper location verification.',
            'longitude.required' => 'GPS Longitude is required for housekeeper location verification.',
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
        ]);

        $property = Property::create($validated);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully with GPS coordinates!');
    }

    /**
     * Display the specified property with details
     */
    public function show(Property $property)
    {
        $property->load([
            'owner',
            'rooms.tasks',
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

        // Get all available tasks for assignment (all tasks are accessible to admin)
        $availableTasks = \App\Models\Task::orderBy('name')->get();

        return view('admin.properties.show', compact('property', 'stats', 'availableTasks'));
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
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Add a room to a property
     */
    public function storeRoom(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_photos' => 'required|integer|min:1|max:50',
        ]);

        $property->rooms()->create([
            'name' => $validated['name'],
            'min_photos' => $validated['min_photos'],
            'is_default' => false,
        ]);

        return back()->with('success', "Room '{$validated['name']}' added successfully!");
    }

    /**
     * Delete a room from a property
     */
    public function destroyRoom(Property $property, $roomId)
    {
        $room = $property->rooms()->findOrFail($roomId);
        $roomName = $room->name;
        $room->delete();

        return back()->with('success', "Room '{$roomName}' deleted successfully!");
    }

    /**
     * Add default rooms to a property
     */
    public function addDefaultRooms(Property $property)
    {
        $defaultRooms = [
            ['name' => 'Living Room', 'min_photos' => 8],
            ['name' => 'Kitchen', 'min_photos' => 8],
            ['name' => 'Bedroom', 'min_photos' => 8],
            ['name' => 'Bathroom', 'min_photos' => 8],
            ['name' => 'Dining Room', 'min_photos' => 8],
            ['name' => 'Laundry Room', 'min_photos' => 8],
            ['name' => 'Garage', 'min_photos' => 8],
            ['name' => 'Patio/Deck', 'min_photos' => 8],
            ['name' => 'Pool Area', 'min_photos' => 8],
        ];

        $added = 0;
        $skipped = 0;

        foreach ($defaultRooms as $roomData) {
            // Check if room with this name already exists
            $exists = $property->rooms()->where('name', $roomData['name'])->exists();
            
            if (!$exists) {
                $property->rooms()->create([
                    'name' => $roomData['name'],
                    'min_photos' => $roomData['min_photos'],
                    'is_default' => true,
                ]);
                $added++;
            } else {
                $skipped++;
            }
        }

        $message = $added > 0 
            ? "{$added} default room(s) added successfully!" . ($skipped > 0 ? " ({$skipped} already existed)" : "")
            : "All default rooms already exist.";

        return back()->with('success', $message);
    }

    /**
     * Attach a task to a room
     */
    public function attachTask(Request $request, Property $property, $roomId)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $room = $property->rooms()->findOrFail($roomId);
        
        // Check if task is already attached
        if ($room->tasks()->where('task_id', $validated['task_id'])->exists()) {
            return back()->with('error', 'This task is already assigned to this room.');
        }

        $room->tasks()->attach($validated['task_id']);

        return back()->with('success', 'Task assigned to room successfully!');
    }

    /**
     * Detach a task from a room
     */
    public function detachTask(Property $property, $roomId, $taskId)
    {
        $room = $property->rooms()->findOrFail($roomId);
        $room->tasks()->detach($taskId);

        return back()->with('success', 'Task removed from room successfully!');
    }
}
