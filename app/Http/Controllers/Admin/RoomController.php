<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of default rooms.
     */
    public function index()
    {
        // Only show default rooms (system-wide templates)
        $rooms = Room::where('is_default', true)
            ->whereNull('property_id')
            ->orderBy('name')
            ->paginate(20);
        
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new default room.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created default room.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_photos' => 'required|integer|min:1|max:50',
        ]);

        // Default rooms have no property_id and is_default = true
        $validated['is_default'] = true;
        $validated['property_id'] = null;

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Default room template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing a default room.
     */
    public function edit(Room $room)
    {
        // Only allow editing default rooms
        if (!$room->is_default || $room->property_id !== null) {
            return back()->with('error', 'Can only edit default room templates.');
        }

        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified default room.
     */
    public function update(Request $request, Room $room)
    {
        // Only allow editing default rooms
        if (!$room->is_default || $room->property_id !== null) {
            return back()->with('error', 'Can only edit default room templates.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_photos' => 'required|integer|min:1|max:50',
        ]);

        // Keep as default room
        $validated['is_default'] = true;
        $validated['property_id'] = null;

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Default room template updated successfully.');
    }

    /**
     * Remove the specified default room.
     */
    public function destroy(Room $room)
    {
        // Only allow deleting default rooms
        if (!$room->is_default || $room->property_id !== null) {
            return back()->with('error', 'Can only delete default room templates.');
        }

        $hasChecklists = $room->checklistItems()->count() > 0;
        
        if ($hasChecklists) {
            return back()->with('error', 'Cannot delete room template that has been used in checklists.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Default room template deleted successfully.');
    }
}
