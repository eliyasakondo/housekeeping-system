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
        // Get owner's properties and housekeepers
        $properties = auth()->user()->properties;
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
            return [
                'id' => $checklist->id,
                'title' => $checklist->property->name . ' - ' . $checklist->housekeeper->name,
                'start' => $checklist->scheduled_date->format('Y-m-d'),
                'backgroundColor' => $this->getStatusColor($checklist->status),
                'borderColor' => $this->getStatusColor($checklist->status),
                'extendedProps' => [
                    'property' => $checklist->property->name,
                    'housekeeper' => $checklist->housekeeper->name,
                    'status' => $checklist->status,
                    'checklist_id' => $checklist->id,
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
