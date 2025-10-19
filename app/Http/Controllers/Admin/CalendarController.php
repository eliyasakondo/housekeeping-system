<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get all properties and housekeepers
        $properties = Property::all();
        $housekeepers = User::where('role', 'housekeeper')->get();
        $owners = User::where('role', 'owner')->get();
        
        return view('admin.calendar.index', compact('properties', 'housekeepers', 'owners'));
    }

    public function getEvents()
    {
        // Get all checklists
        $checklists = Checklist::with(['property', 'housekeeper', 'assignedBy'])->get();

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
                    'owner' => $checklist->property->owner->name,
                    'status' => $checklist->status,
                    'checklist_id' => $checklist->id,
                ]
            ];
        });

        return response()->json($events);
    }

    public function show(Checklist $checklist)
    {
        $checklist->load(['property', 'housekeeper', 'assignedBy', 'items.task', 'items.room', 'photos']);

        return response()->json([
            'checklist' => $checklist,
            'property' => $checklist->property,
            'housekeeper' => $checklist->housekeeper,
            'items' => $checklist->items,
            'photos' => $checklist->photos,
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
