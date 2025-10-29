<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    public function index(Request $request)
    {
        $query = Checklist::with(['property.rooms', 'housekeeper', 'room'])
            ->whereHas('property', function($q) {
                $q->where('owner_id', auth()->id());
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('property', function($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('room', function($rq) use ($search) {
                    $rq->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('housekeeper', function($hq) use ($search) {
                    $hq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $checklists = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get properties with their readiness status
        $properties = auth()->user()->properties()->with('rooms.tasks')->get();
        
        // Add a flag to indicate if property is ready for assignment
        $properties->each(function($property) {
            $property->is_ready = $property->rooms->count() > 0 && 
                                  $property->rooms->contains(function($room) {
                                      return $room->tasks->count() > 0;
                                  });
        });

        return view('owner.checklists.index', compact('checklists', 'properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'housekeeper_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'nullable|date_format:H:i',
        ]);

        // Verify property belongs to owner
        $property = Property::where('id', $validated['property_id'])
            ->where('owner_id', auth()->id())
            ->firstOrFail();

        // Verify housekeeper belongs to owner
        $housekeeper = User::where('id', $validated['housekeeper_id'])
            ->where('role', 'housekeeper')
            ->where('owner_id', auth()->id())
            ->firstOrFail();

        // Check if property has any rooms
        $roomCount = $property->rooms()->count();
        if ($roomCount === 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cannot create assignment: This property has no rooms. Please add rooms first.');
        }

        // Check if property has any tasks assigned to rooms
        $hasTasksAssigned = false;
        foreach ($property->rooms as $room) {
            if ($room->tasks()->count() > 0) {
                $hasTasksAssigned = true;
                break;
            }
        }

        if (!$hasTasksAssigned) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cannot create assignment: No tasks have been assigned to any rooms in this property. Please assign tasks to rooms first.');
        }

        Checklist::create([
            'property_id' => $validated['property_id'],
            'housekeeper_id' => $validated['housekeeper_id'],
            'assigned_by' => auth()->id(),
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('owner.checklists.index')
            ->with('success', 'Task assigned successfully!');
    }

    public function show(Checklist $checklist)
    {
        // Make sure the checklist belongs to owner's property
        if ($checklist->property->owner_id !== auth()->id()) {
            abort(403);
        }

        $checklist->load([
            'property.rooms', 
            'housekeeper', 
            'room', 
            'checklistItems.task', 
            'photos.room', 
            'inventoryItems'
        ]);
        
        return view('owner.checklists.show', compact('checklist'));
    }

    public function destroy(Checklist $checklist)
    {
        // Make sure the checklist belongs to owner's property
        if ($checklist->property->owner_id !== auth()->id()) {
            abort(403);
        }

        $checklist->delete();

        return redirect()->route('owner.checklists.index')
            ->with('success', 'Checklist deleted successfully.');
    }
}
