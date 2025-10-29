<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    public function index()
    {
        // Get owner's properties with readiness status
        $properties = auth()->user()->properties()->with('rooms.tasks')->get();
        
        // Add a flag to indicate if property is ready for assignment
        $properties->each(function($property) {
            $property->is_ready = $property->rooms->count() > 0 && 
                                  $property->rooms->contains(function($room) {
                                      return $room->tasks->count() > 0;
                                  });
        });
        
        $housekeepers = User::where('role', 'housekeeper')
            ->where('owner_id', auth()->id())
            ->get();
        
        return view('owner.calendar.index', compact('properties', 'housekeepers'));
    }

    public function getEvents()
    {
        // Get all checklists for owner's properties
        $checklists = Checklist::whereHas('property', function($query) {
            $query->where('owner_id', auth()->id());
        })->with(['property', 'housekeeper'])->get();

        // Format for calendar
        $events = $checklists->map(function($checklist) {
            // Combine date and time if time is set
            $startDateTime = $checklist->scheduled_date->format('Y-m-d');
            if ($checklist->scheduled_time) {
                $startDateTime .= ' ' . $checklist->scheduled_time;
            }

            return [
                'id' => $checklist->id,
                'title' => $checklist->property->name . ' - ' . $checklist->housekeeper->name,
                'start' => $startDateTime,
                'allDay' => !$checklist->scheduled_time, // Only all-day if no time is set
                'backgroundColor' => $this->getStatusColor($checklist->status),
                'borderColor' => $this->getStatusColor($checklist->status),
                'extendedProps' => [
                    'property' => $checklist->property->name,
                    'housekeeper' => $checklist->housekeeper->name,
                    'status' => $checklist->status,
                    'checklist_id' => $checklist->id,
                    'scheduled_time' => $checklist->scheduled_time,
                ]
            ];
        });

        return response()->json($events);
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
            return response()->json([
                'success' => false,
                'message' => 'Cannot create assignment: This property has no rooms. Please add rooms first.'
            ], 422);
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
            return response()->json([
                'success' => false,
                'message' => 'Cannot create assignment: No tasks have been assigned to any rooms in this property. Please assign tasks to rooms first.'
            ], 422);
        }

        $checklist = Checklist::create([
            'property_id' => $validated['property_id'],
            'housekeeper_id' => $validated['housekeeper_id'],
            'assigned_by' => auth()->id(),
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment created successfully!',
            'checklist' => $checklist->load(['property', 'housekeeper'])
        ]);
    }

    public function show(Checklist $checklist)
    {
        // Verify checklist belongs to owner's property
        if ($checklist->property->owner_id !== auth()->id()) {
            abort(403);
        }

        $checklist->load(['property', 'housekeeper', 'items.task', 'items.room', 'photos']);

        return response()->json([
            'checklist' => $checklist,
            'property' => $checklist->property,
            'housekeeper' => $checklist->housekeeper,
            'items' => $checklist->items,
            'photos' => $checklist->photos,
        ]);
    }

    public function quickAssign()
    {
        // Get owner's properties with readiness status
        $properties = auth()->user()->properties()->with('rooms.tasks')->get();
        
        // Add a flag to indicate if property is ready for assignment
        $properties->each(function($property) {
            $property->is_ready = $property->rooms->count() > 0 && 
                                  $property->rooms->contains(function($room) {
                                      return $room->tasks->count() > 0;
                                  });
        });
        
        $housekeepers = User::where('role', 'housekeeper')
            ->where('owner_id', auth()->id())
            ->get();
        
        return view('owner.assign-housekeeper', compact('properties', 'housekeepers'));
    }

    public function destroy(Checklist $checklist)
    {
        // Verify checklist belongs to owner's property
        if ($checklist->property->owner_id !== auth()->id()) {
            abort(403);
        }

        // Only allow deletion of pending checklists
        if ($checklist->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a checklist that has been started or completed.'
            ], 422);
        }

        $checklist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully!'
        ]);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'pending' => '#6c757d',      // Gray
            'in_progress' => '#0dcaf0',  // Cyan
            'completed' => '#198754',    // Green
            default => '#6c757d'
        };
    }
}
