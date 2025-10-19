<?php

namespace App\Http\Controllers\Housekeeper;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Models\Photo;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:housekeeper']);
    }

    public function show(Checklist $checklist)
    {
        $this->authorize('view', $checklist);
        
        // Load relationships with fresh data
        $checklist->load(['property.rooms', 'items.room', 'items.task']);
        $checklist->load(['photos' => function($query) {
            $query->orderBy('taken_at', 'desc');
        }]);
        
        return view('housekeeper.checklist.show', compact('checklist'));
    }

    public function start(Checklist $checklist, Request $request)
    {
        $this->authorize('update', $checklist);

        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Verify GPS location is near property
        $property = $checklist->property;
        $gpsVerified = $this->verifyGPSLocation(
            $validated['latitude'],
            $validated['longitude'],
            $property->latitude,
            $property->longitude
        );

        // REQUIREMENT: "The checklist becomes available ONLY when the user's GPS confirms they are at the property"
        if (!$gpsVerified) {
            \Log::warning('GPS verification failed for checklist', [
                'checklist_id' => $checklist->id,
                'user_location' => ['lat' => $validated['latitude'], 'lng' => $validated['longitude']],
                'property_location' => ['lat' => $property->latitude, 'lng' => $property->longitude],
            ]);
            
            return back()->with('error', 'You must be at the property location to start the checklist. Please ensure your GPS is enabled and you are within 100 meters of the property.');
        }

        // Get first room for the property
        $firstRoom = $property->rooms()->orderBy('id')->first();

        $checklist->update([
            'status' => 'in_progress',
            'workflow_step' => 'tasks',
            'current_room_id' => $firstRoom?->id,
            'started_at' => now(),
            'gps_latitude' => $validated['latitude'],
            'gps_longitude' => $validated['longitude'],
            'gps_verified' => $gpsVerified,
        ]);

        // Create checklist items for all rooms and tasks
        $this->createChecklistItems($checklist);
        
        // Create inventory items
        $this->createInventoryItems($checklist);

        return redirect()->route('housekeeper.checklist.show', $checklist)
            ->with('success', 'Checklist started successfully!');
    }

    public function completeItem(Checklist $checklist, ChecklistItem $item, Request $request)
    {
        $this->authorize('update', $checklist);

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $item->update([
            'is_completed' => true,
            'completed_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json(['success' => true]);
    }

    public function completeRoom(Checklist $checklist, Request $request)
    {
        $this->authorize('update', $checklist);

        $currentRoom = $checklist->currentRoom;
        
        if (!$currentRoom) {
            return back()->with('error', 'No current room set.');
        }

        // Verify all tasks in current room are completed
        $incompleteTasks = $checklist->items()
            ->where('room_id', $currentRoom->id)
            ->where('is_completed', false)
            ->count();

        if ($incompleteTasks > 0) {
            return back()->with('error', "Please complete all tasks in {$currentRoom->name} before proceeding.");
        }

        // Find next room
        $nextRoom = $checklist->property->rooms()
            ->where('id', '>', $currentRoom->id)
            ->orderBy('id')
            ->first();

        if ($nextRoom) {
            // Move to next room
            $checklist->update([
                'current_room_id' => $nextRoom->id,
            ]);
            return redirect()->route('housekeeper.checklist.show', $checklist)
                ->with('success', "Room '{$currentRoom->name}' completed! Now working on: {$nextRoom->name}");
        } else {
            // All rooms completed, move to inventory step
            $checklist->update([
                'current_room_id' => null,
                'workflow_step' => 'inventory',
                'tasks_completed_at' => now(),
            ]);
            return redirect()->route('housekeeper.checklist.show', $checklist)
                ->with('success', 'All room tasks completed! Please review the inventory checklist.');
        }
    }

    public function completeInventory(Checklist $checklist, Request $request)
    {
        $this->authorize('update', $checklist);

        if ($checklist->workflow_step !== 'inventory') {
            return back()->with('error', 'Inventory step is not available yet.');
        }

        // Verify all inventory items are checked
        $incompleteItems = $checklist->inventoryItems()
            ->where('is_completed', false)
            ->count();

        if ($incompleteItems > 0) {
            return back()->with('error', 'Please complete all inventory items before proceeding.');
        }

        // Move to photos step
        $checklist->update([
            'workflow_step' => 'photos',
            'inventory_completed_at' => now(),
        ]);

        return redirect()->route('housekeeper.checklist.show', $checklist)
            ->with('success', 'Inventory completed! Now you can upload photos for each room.');
    }

    public function completeInventoryItem(Checklist $checklist, $itemId, Request $request)
    {
        $this->authorize('update', $checklist);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $item = $checklist->inventoryItems()->findOrFail($itemId);
        
        $item->update([
            'quantity' => $validated['quantity'],
            'is_available' => $validated['is_available'],
            'notes' => $validated['notes'] ?? null,
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function uploadPhoto(Checklist $checklist, Request $request)
    {
        $this->authorize('update', $checklist);

        // Only allow photo uploads in the photos step
        if ($checklist->workflow_step !== 'photos') {
            return response()->json([
                'success' => false,
                'message' => 'Photos can only be uploaded after completing tasks and inventory.'
            ], 403);
        }

        try {
            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'photos' => 'required|array',
                'photos.*' => 'required|image|max:10240', // 10MB max per image
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        }

        $uploadedCount = 0;
        $path = 'photos/' . $checklist->id;
        $savedFiles = [];
        
        try {
            Storage::disk('public')->makeDirectory($path);

            foreach ($request->file('photos') as $index => $file) {
                // Create a clean filename with timestamp
                $extension = $file->getClientOriginalExtension();
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);
                $filename = date('Ymd_His') . '_' . $index . '_' . $cleanName . '.' . $extension;
                $saved = false;

                // REQUIREMENT: "timestamp overlay (not editable)" on photos
                // Try to add timestamp overlay if GD extension is available
                if (extension_loaded('gd')) {
                    try {
                        // Use Intervention Image to add timestamp overlay
                        $manager = new ImageManager(new Driver());
                        $image = $manager->read($file);
                        
                        $timestamp = now()->format('Y-m-d H:i:s');
                        
                        // Add semi-transparent black background for timestamp
                        $image->drawRectangle(5, 5, function ($rectangle) {
                            $rectangle->size(320, 40);
                            $rectangle->background('rgba(0, 0, 0, 0.7)');
                        });
                        
                        // Add timestamp text (uses GD's built-in font, no TTF needed)
                        $image->text($timestamp, 15, 30, function($font) {
                            $font->size(24);
                            $font->color('#ffffff');
                            $font->align('left');
                            $font->valign('middle');
                        });
                        
                        // Save using Laravel Storage API (works on all servers)
                        $encodedImage = $image->encode();
                        Storage::disk('public')->put($path . '/' . $filename, $encodedImage);
                        $saved = Storage::disk('public')->exists($path . '/' . $filename);

                        \Log::info('Photo saved with timestamp overlay', [
                            'filename' => $filename,
                            'timestamp' => $timestamp,
                            'path' => $path . '/' . $filename,
                            'saved' => $saved,
                        ]);
                    } catch (\Exception $imageError) {
                        // If image processing fails, fall back to regular upload
                        \Log::warning('Image processing failed, saving without overlay', [
                            'error' => $imageError->getMessage()
                        ]);
                        Storage::disk('public')->putFileAs($path, $file, $filename);
                        $saved = Storage::disk('public')->exists($path . '/' . $filename);
                        \Log::info('Photo saved via putFileAs after image error', ['filename' => $filename, 'saved' => $saved]);
                    }
                } else {
                    // GD not available, store without overlay
                    \Log::warning('GD extension not available, saving photo without timestamp overlay');
                    Storage::disk('public')->putFileAs($path, $file, $filename);
                    $saved = Storage::disk('public')->exists($path . '/' . $filename);
                    \Log::info('Photo saved via putFileAs (no GD)', ['filename' => $filename, 'saved' => $saved]);
                }

                Photo::create([
                    'checklist_id' => $checklist->id,
                    'room_id' => $validated['room_id'],
                    'file_path' => $path . '/' . $filename,
                    'original_filename' => $file->getClientOriginalName(),
                    'taken_at' => now(),
                    'gps_latitude' => $validated['latitude'] ?? null,
                    'gps_longitude' => $validated['longitude'] ?? null,
                ]);

                $savedFiles[] = [
                    'filename' => $filename,
                    'path' => $path . '/' . $filename,
                    'saved' => $saved,
                ];

                if ($saved) {
                    $uploadedCount++;
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photos: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true, 
            'message' => $uploadedCount . ' photo(s) uploaded successfully',
            'count' => $uploadedCount,
            'files' => $savedFiles,
        ]);
    }

    public function summary(Checklist $checklist)
    {
        $this->authorize('view', $checklist);

        // Get all completed items grouped by room
        $itemsByRoom = $checklist->items()->with(['task', 'room'])->get()->groupBy('room_id');
        
        // Get all photos grouped by room
        $photosByRoom = $checklist->photos()->with('room')->get()->groupBy('room_id');

        return view('housekeeper.checklist.summary', compact('checklist', 'itemsByRoom', 'photosByRoom'));
    }

    public function complete(Checklist $checklist, Request $request)
    {
        $this->authorize('update', $checklist);

        // Verify all rooms have minimum photos
        foreach ($checklist->property->rooms as $room) {
            $photoCount = $checklist->photos()->where('room_id', $room->id)->count();
            if ($photoCount < $room->min_photos) {
                return back()->with('error', "Room '{$room->name}' requires at least {$room->min_photos} photos. Currently has {$photoCount}.");
            }
        }

        $checklist->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('housekeeper.dashboard')
            ->with('success', 'Checklist completed successfully!');
    }

    private function verifyGPSLocation($lat1, $lon1, $lat2, $lon2, $maxDistance = 0.1)
    {
        if (!$lat2 || !$lon2) return true; // If property has no GPS, skip verification

        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance <= $maxDistance;
    }

    private function createChecklistItems(Checklist $checklist)
    {
        // Create checklist items only for tasks assigned to each room
        foreach ($checklist->property->rooms as $room) {
            // Get tasks specifically assigned to this room
            $roomTasks = $room->tasks;
            
            // If no specific tasks assigned, fall back to default tasks
            if ($roomTasks->isEmpty()) {
                $roomTasks = Task::where('is_default', true)->get();
            }
            
            foreach ($roomTasks as $task) {
                ChecklistItem::create([
                    'checklist_id' => $checklist->id,
                    'room_id' => $room->id,
                    'task_id' => $task->id,
                    'is_completed' => false,
                ]);
            }
        }
    }

    private function createInventoryItems(Checklist $checklist)
    {
        // Common inventory items for Airbnb properties
        $inventoryItems = [
            'Towels',
            'Bed Sheets',
            'Pillowcases',
            'Toilet Paper',
            'Paper Towels',
            'Hand Soap',
            'Shampoo',
            'Conditioner',
            'Dish Soap',
            'Trash Bags',
            'Coffee/Tea',
            'Kitchen Utensils',
        ];

        foreach ($inventoryItems as $itemName) {
            \App\Models\InventoryItem::create([
                'checklist_id' => $checklist->id,
                'item_name' => $itemName,
                'quantity' => 0,
                'is_available' => true,
                'is_completed' => false,
            ]);
        }
    }
}
