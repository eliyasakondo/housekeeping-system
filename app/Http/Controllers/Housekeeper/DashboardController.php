<?php

namespace App\Http\Controllers\Housekeeper;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:housekeeper']);
    }

    public function index()
    {
        $housekeeper = auth()->user();

        $stats = [
            'pending' => $housekeeper->checklists()->where('status', 'pending')->count(),
            'in_progress' => $housekeeper->checklists()->where('status', 'in_progress')->count(),
            'completed_today' => $housekeeper->checklists()
                ->where('status', 'completed')
                ->whereDate('completed_at', today())
                ->count(),
            'total_completed' => $housekeeper->checklists()->where('status', 'completed')->count(),
        ];

        $upcoming = $housekeeper->checklists()
            ->with(['property', 'property.rooms'])
            ->where('status', 'pending')
            ->orderBy('scheduled_date')
            ->get();

        $in_progress = $housekeeper->checklists()
            ->with(['property', 'property.rooms'])
            ->where('status', 'in_progress')
            ->latest()
            ->get();

        return view('housekeeper.dashboard', compact('stats', 'upcoming', 'in_progress'));
    }
}
