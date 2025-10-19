<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerId = auth()->id();
        
        // Get tasks for owner's properties + default tasks
        $tasks = Task::where(function($query) use ($ownerId) {
            $query->where('is_default', true)
                  ->orWhereHas('property', function($q) use ($ownerId) {
                      $q->where('owner_id', $ownerId);
                  });
        })
        ->with(['property', 'rooms']) // Changed from 'room' to 'rooms' (many-to-many)
        ->orderBy('is_default', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        return view('owner.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ownerId = auth()->id();
        $properties = Property::where('owner_id', $ownerId)->get();
        $rooms = Room::whereHas('property', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->get();
        
        return view('owner.tasks.create', compact('properties', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ownerId = auth()->id();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        // If property_id is provided, verify owner owns the property
        if (isset($validated['property_id'])) {
            $property = Property::findOrFail($validated['property_id']);
            if ($property->owner_id !== $ownerId) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
                abort(403, 'Unauthorized');
            }
        } else {
            // If no property_id, assign to first property (for quick create)
            $property = Property::where('owner_id', $ownerId)->first();
            if (!$property) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'No property found'], 404);
                }
                return redirect()->back()->with('error', 'No property found');
            }
            $validated['property_id'] = $property->id;
        }

        // Custom tasks are never default
        $validated['is_default'] = false;

        $task = Task::create($validated);

        // For AJAX requests, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'task' => $task
            ]);
        }

        return redirect()->route('owner.tasks.index')
            ->with('success', 'Task created successfully. You can now assign it to rooms from the property page.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Only allow editing custom tasks for own properties
        if ($task->is_default) {
            return back()->with('error', 'Cannot edit default tasks.');
        }

        $ownerId = auth()->id();
        
        if (!$task->property || $task->property->owner_id !== $ownerId) {
            abort(403, 'Unauthorized');
        }

        $properties = Property::where('owner_id', $ownerId)->get();
        $rooms = Room::whereHas('property', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->get();
        
        return view('owner.tasks.edit', compact('task', 'properties', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Only allow editing custom tasks
        if ($task->is_default) {
            return back()->with('error', 'Cannot edit default tasks.');
        }

        $ownerId = auth()->id();
        
        if (!$task->property || $task->property->owner_id !== $ownerId) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'property_id' => 'required|exists:properties,id',
            // 'room_id' removed - tasks are now assigned to rooms via property management
        ]);

        // Verify new property belongs to owner
        $property = Property::findOrFail($validated['property_id']);
        if ($property->owner_id !== $ownerId) {
            abort(403, 'Unauthorized');
        }

        $validated['is_default'] = false;
        $task->update($validated);

        return redirect()->route('owner.tasks.index')
            ->with('success', 'Task updated successfully. Assign it to rooms from the property page.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Only allow deleting custom tasks
        if ($task->is_default) {
            return back()->with('error', 'Cannot delete default tasks.');
        }

        $ownerId = auth()->id();
        
        if (!$task->property || $task->property->owner_id !== $ownerId) {
            abort(403, 'Unauthorized');
        }

        // Check if task is used in any checklists
        $hasChecklists = $task->checklistItems()->count() > 0;
        
        if ($hasChecklists) {
            return back()->with('error', 'Cannot delete task that has been used in checklists.');
        }

        $task->delete();

        return redirect()->route('owner.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
