<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = Checklist::with(['property', 'housekeeper']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by housekeeper
        if ($request->filled('housekeeper_id')) {
            $query->where('housekeeper_id', $request->housekeeper_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by checklist ID or property name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('property', function($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $checklists = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get all properties and housekeepers for filters
        $properties = \App\Models\Property::orderBy('name')->get();
        $housekeepers = \App\Models\User::where('role', 'housekeeper')->orderBy('name')->get();

        return view('admin.checklists.index', compact('checklists', 'properties', 'housekeepers'));
    }

    public function show(Checklist $checklist)
    {
        $checklist->load([
            'property.rooms',
            'housekeeper',
            'items.room',
            'items.task',
            'inventoryItems',
            'photos.room'
        ]);

        // Group items by room
        $itemsByRoom = $checklist->items->groupBy('room_id');
        
        // Group photos by room
        $photosByRoom = $checklist->photos->groupBy('room_id');

        return view('admin.checklists.show', compact('checklist', 'itemsByRoom', 'photosByRoom'));
    }

    public function destroy(Checklist $checklist)
    {
        // Delete all related data
        $checklist->items()->delete();
        $checklist->inventoryItems()->delete();
        
        // Delete photos from storage and database
        foreach ($checklist->photos as $photo) {
            \Storage::disk('public')->delete($photo->file_path);
            $photo->delete();
        }

        $checklist->delete();

        return redirect()->route('admin.checklists.index')
            ->with('success', 'Checklist deleted successfully.');
    }
}
