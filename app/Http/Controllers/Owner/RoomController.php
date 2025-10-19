<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    /**
     * Display rooms for a specific property.
     */
    public function index(Property $property)
    {
        // Verify property belongs to owner
        if ($property->owner_id !== auth()->id()) {
            abort(403);
        }

        $rooms = $property->rooms()->paginate(10);
        return view('owner.rooms.index', compact('property', 'rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(Property $property)
    {
        // Verify property belongs to owner
        if ($property->owner_id !== auth()->id()) {
            abort(403);
        }

        return view('owner.rooms.create', compact('property'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request, Property $property)
    {
        // Verify property belongs to owner
        if ($property->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_photos' => 'required|integer|min:1|max:50',
        ]);

        $property->rooms()->create($validated);

        return redirect()->route('owner.properties.show', $property)
            ->with('success', 'Room added successfully.');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Property $property, Room $room)
    {
        // Verify property belongs to owner and room belongs to property
        if ($property->owner_id !== auth()->id() || $room->property_id !== $property->id) {
            abort(403);
        }

        return view('owner.rooms.edit', compact('property', 'room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Property $property, Room $room)
    {
        // Verify property belongs to owner and room belongs to property
        if ($property->owner_id !== auth()->id() || $room->property_id !== $property->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_photos' => 'required|integer|min:1|max:50',
        ]);

        $room->update($validated);

        return redirect()->route('owner.properties.show', $property)
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Property $property, Room $room)
    {
        // Verify property belongs to owner and room belongs to property
        if ($property->owner_id !== auth()->id() || $room->property_id !== $property->id) {
            abort(403);
        }

        // Check if room has any checklist items
        $hasChecklists = $room->checklistItems()->count() > 0;

        if ($hasChecklists) {
            return back()->with('error', 'Cannot delete room that has been used in checklists. This would affect historical data.');
        }

        $room->delete();

        return redirect()->route('owner.rooms.index', $property)
            ->with('success', 'Room deleted successfully.');
    }

    /**
     * Attach tasks to a room.
     */
    public function attachTask(Request $request, Property $property, Room $room)
    {
        // Verify property belongs to owner and room belongs to property
        if ($property->owner_id !== auth()->id() || $room->property_id !== $property->id) {
            abort(403);
        }

        // Debug logging
        \Log::info('Attach Task Request', [
            'property_id' => $property->id,
            'room_id' => $room->id,
            'request_data' => $request->all(),
            'task_ids' => $request->input('task_ids'),
        ]);

        $validated = $request->validate([
            'task_ids' => 'required|array|min:1',
            'task_ids.*' => 'exists:tasks,id',
        ]);

        // Attach tasks to the room (sync will not detach existing tasks)
        $room->tasks()->syncWithoutDetaching($validated['task_ids']);
        
        \Log::info('Tasks attached successfully', [
            'room_id' => $room->id,
            'task_ids' => $validated['task_ids']
        ]);

        return redirect()->route('owner.properties.show', $property)
            ->with('success', 'Tasks assigned to ' . $room->name . ' successfully.');
    }

    /**
     * Detach a task from a room.
     */
    public function detachTask(Property $property, Room $room, \App\Models\Task $task)
    {
        // Verify property belongs to owner and room belongs to property
        if ($property->owner_id !== auth()->id() || $room->property_id !== $property->id) {
            abort(403);
        }

        $room->tasks()->detach($task->id);

        return redirect()->route('owner.properties.show', $property)
            ->with('success', 'Task removed from ' . $room->name . ' successfully.');
    }

    /**
     * Bulk add default rooms to a property.
     */
    public function addDefaults(Request $request, Property $property)
    {
        // Verify property belongs to owner
        if ($property->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'default_room_ids' => 'required|array',
            'default_room_ids.*' => 'exists:rooms,id',
        ]);

        // Get the default rooms
        $defaultRooms = Room::whereIn('id', $validated['default_room_ids'])
            ->where('is_default', true)
            ->get();

        $addedCount = 0;

        foreach ($defaultRooms as $defaultRoom) {
            // Create a copy of the default room for this property
            $newRoom = $property->rooms()->create([
                'name' => $defaultRoom->name,
                'description' => $defaultRoom->description,
                'min_photos' => $defaultRoom->min_photos,
                'is_default' => false, // This is a copy, not a default
            ]);

            // If the default room has tasks assigned, copy those relationships too
            if ($defaultRoom->tasks()->count() > 0) {
                $taskIds = $defaultRoom->tasks()->pluck('tasks.id')->toArray();
                $newRoom->tasks()->attach($taskIds);
            }

            $addedCount++;
        }

        return redirect()->route('owner.properties.show', $property)
            ->with('success', $addedCount . ' default room(s) added successfully.');
    }
}
