<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Checklist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database's seeder.
     */
    public function run(): void
    {
        // Get all in_progress or completed checklists
        $checklists = Checklist::whereIn('status', ['in_progress', 'completed'])->get();

        foreach ($checklists as $checklist) {
            $this->command->info("Creating photos for Checklist #{$checklist->id}...");
            
            // Create photos for each room
            foreach ($checklist->property->rooms as $room) {
                $photosToCreate = $room->min_photos;
                
                for ($i = 1; $i <= $photosToCreate; $i++) {
                    $this->createPhoto($checklist, $room, $i);
                }
                
                $this->command->info("  - Created {$photosToCreate} photos for {$room->name}");
            }
        }

        $this->command->info('Photo seeding completed!');
    }

    private function createPhoto($checklist, $room, $index)
    {
        // Generate random placeholder image from picsum.photos
        $width = 800;
        $height = 600;
        $imageId = rand(1, 1000); // Random image from picsum
        
        try {
            // Download placeholder image
            $imageUrl = "https://picsum.photos/seed/{$room->id}{$index}/{$width}/{$height}";
            $imageContent = Http::timeout(10)->get($imageUrl)->body();
            
            // Save the image
            $path = 'photos/' . $checklist->id;
            Storage::disk('public')->makeDirectory($path);
            
            $filename = 'seed_' . time() . '_' . $room->id . '_' . $index . '_' . uniqid() . '.jpg';
            $fullPath = $path . '/' . $filename;
            
            Storage::disk('public')->put($fullPath, $imageContent);
            
            // Create photo record
            Photo::create([
                'checklist_id' => $checklist->id,
                'room_id' => $room->id,
                'file_path' => $fullPath,
                'original_filename' => "room_{$room->name}_photo_{$index}.jpg",
                'taken_at' => now()->subMinutes(rand(5, 60)),
                'gps_latitude' => $checklist->property->latitude,
                'gps_longitude' => $checklist->property->longitude,
            ]);
            
            // Small delay to ensure unique timestamps and avoid rate limiting
            usleep(200000); // 0.2 second
            
        } catch (\Exception $e) {
            $this->command->warn("  - Failed to download image: " . $e->getMessage());
            $this->command->warn("  - Creating empty placeholder instead...");
            
            // Create a simple text file as placeholder if download fails
            $path = 'photos/' . $checklist->id;
            Storage::disk('public')->makeDirectory($path);
            
            $filename = 'placeholder_' . time() . '_' . $room->id . '_' . $index . '.txt';
            $fullPath = $path . '/' . $filename;
            
            $placeholderText = "Photo placeholder for {$room->name} - Photo #{$index}\nTimestamp: " . now()->format('Y-m-d H:i:s');
            Storage::disk('public')->put($fullPath, $placeholderText);
            
            // Create photo record
            Photo::create([
                'checklist_id' => $checklist->id,
                'room_id' => $room->id,
                'file_path' => $fullPath,
                'original_filename' => "room_{$room->name}_photo_{$index}.jpg",
                'taken_at' => now()->subMinutes(rand(5, 60)),
                'gps_latitude' => $checklist->property->latitude,
                'gps_longitude' => $checklist->property->longitude,
            ]);
        }
    }
}
