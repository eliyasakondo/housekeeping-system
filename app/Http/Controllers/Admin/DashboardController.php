<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Checklist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_owners' => User::where('role', 'owner')->count(),
            'total_housekeepers' => User::where('role', 'housekeeper')->count(),
            'total_properties' => Property::count(),
            'total_checklists' => Checklist::count(),
            'pending_checklists' => Checklist::where('status', 'pending')->count(),
            'completed_checklists' => Checklist::where('status', 'completed')->count(),
        ];

        $recent_checklists = Checklist::with(['property', 'housekeeper'])
            ->latest()
            ->take(10)
            ->get();

        // Check if user should see welcome tutorial
        $showWelcomeTutorial = false;
        if (auth()->user() && !auth()->user()->welcome_tutorial_dismissed) {
            // Only show if not shown in this session
            if (!session()->has('welcome_tutorial_shown')) {
                $showWelcomeTutorial = true;
                session()->put('welcome_tutorial_shown', true);
                
                // Update the timestamp when tutorial is shown
                auth()->user()->update(['welcome_tutorial_shown_at' => now()]);
            }
        }

        return view('admin.dashboard', compact('stats', 'recent_checklists', 'showWelcomeTutorial'));
    }
    
    public function dismissWelcomeTutorial(Request $request)
    {
        $user = auth()->user();
        $user->update(['welcome_tutorial_dismissed' => true]);
        
        return response()->json(['success' => true]);
    }
}
