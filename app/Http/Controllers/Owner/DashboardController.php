<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Checklist;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:owner']);
    }

    public function index()
    {
        $owner = auth()->user();

        // Check if we should show the welcome tutorial
        $showWelcomeTutorial = false;
        if ($owner && !$owner->welcome_tutorial_dismissed) {
            if (!session()->has('welcome_tutorial_shown')) {
                $showWelcomeTutorial = true;
                session()->put('welcome_tutorial_shown', true);
                $owner->update(['welcome_tutorial_shown_at' => now()]);
            }
        }

        $stats = [
            'total_properties' => $owner->properties()->count(),
            'total_housekeepers' => $owner->housekeepers()->count(),
            'pending_checklists' => Checklist::whereHas('property', function($q) use ($owner) {
                $q->where('owner_id', $owner->id);
            })->where('status', 'pending')->count(),
            'completed_today' => Checklist::whereHas('property', function($q) use ($owner) {
                $q->where('owner_id', $owner->id);
            })->where('status', 'completed')->whereDate('completed_at', today())->count(),
        ];

        $recent_checklists = Checklist::with(['property', 'housekeeper'])
            ->whereHas('property', function($q) use ($owner) {
                $q->where('owner_id', $owner->id);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('owner.dashboard', compact('stats', 'recent_checklists', 'showWelcomeTutorial'));
    }

    public function dismissWelcomeTutorial(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'welcome_tutorial_dismissed' => true,
        ]);

        return response()->json(['success' => true]);
    }
}
