<?php

namespace App\Http\Controllers\Housekeeper;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:housekeeper']);
    }

    public function index()
    {
        return view('housekeeper.calendar.index');
    }

    public function getEvents()
    {
        // Get only checklists assigned to this housekeeper
        $checklists = Checklist::where('housekeeper_id', auth()->id())
            ->with(['property'])
            ->get();

        // Format for calendar
        $events = $checklists->map(function($checklist) {
            // Combine date and time if time is set
            $startDateTime = $checklist->scheduled_date->format('Y-m-d');
            if ($checklist->scheduled_time) {
                $startDateTime .= ' ' . $checklist->scheduled_time;
            }

            return [
                'id' => $checklist->id,
                'title' => $checklist->property->name,
                'start' => $startDateTime,
                'allDay' => !$checklist->scheduled_time, // Only all-day if no time is set
                'backgroundColor' => $this->getStatusColor($checklist->status),
                'borderColor' => $this->getStatusColor($checklist->status),
                'url' => route('housekeeper.checklist.show', $checklist),
                'extendedProps' => [
                    'property' => $checklist->property->name,
                    'address' => $checklist->property->address,
                    'status' => $checklist->status,
                    'checklist_id' => $checklist->id,
                    'scheduled_time' => $checklist->scheduled_time,
                ]
            ];
        });

        return response()->json($events);
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
