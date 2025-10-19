<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\Task;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@housekeeping.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1-555-0100',
        ]);

        // Create Owner
        $owner = User::create([
            'name' => 'John Property Owner',
            'email' => 'owner@housekeeping.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '+1-555-0101',
        ]);

        // Create Housekeepers
        $housekeeper1 = User::create([
            'name' => 'Maria Housekeeper',
            'email' => 'maria@housekeeping.com',
            'password' => Hash::make('password'),
            'role' => 'housekeeper',
            'owner_id' => $owner->id,
            'phone' => '+1-555-0102',
        ]);

        $housekeeper2 = User::create([
            'name' => 'Carlos Cleaner',
            'email' => 'carlos@housekeeping.com',
            'password' => Hash::make('password'),
            'role' => 'housekeeper',
            'owner_id' => $owner->id,
            'phone' => '+1-555-0103',
        ]);

        // Create Properties
        $property1 = Property::create([
            'owner_id' => $owner->id,
            'name' => 'Sunset Beach House',
            'beds' => 4,
            'baths' => 3,
            'address' => '123 Ocean Drive, Miami Beach, FL 33139',
            'latitude' => 25.7617,
            'longitude' => -80.1918,
            'description' => 'Beautiful beachfront property with 4 bedrooms',
        ]);

        $property2 = Property::create([
            'owner_id' => $owner->id,
            'name' => 'Downtown Loft Apartment',
            'beds' => 2,
            'baths' => 2,
            'address' => '456 Main Street, Miami, FL 33130',
            'latitude' => 25.7743,
            'longitude' => -80.1937,
            'description' => 'Modern loft in the heart of downtown',
        ]);

        // Create Rooms for Property 1
        $rooms1 = [
            Room::create(['property_id' => $property1->id, 'name' => 'Master Bedroom', 'description' => 'King bed with ocean view', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Guest Bedroom 1', 'description' => 'Queen bed', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Guest Bedroom 2', 'description' => 'Two twin beds', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Living Room', 'description' => 'Spacious living area', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Kitchen', 'description' => 'Fully equipped kitchen', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Master Bathroom', 'description' => 'En-suite bathroom', 'min_photos' => 8]),
            Room::create(['property_id' => $property1->id, 'name' => 'Guest Bathroom', 'description' => 'Full bathroom', 'min_photos' => 8]),
        ];

        // Create Rooms for Property 2
        $rooms2 = [
            Room::create(['property_id' => $property2->id, 'name' => 'Bedroom', 'description' => 'Queen bed', 'min_photos' => 8]),
            Room::create(['property_id' => $property2->id, 'name' => 'Living Area', 'description' => 'Open concept living space', 'min_photos' => 8]),
            Room::create(['property_id' => $property2->id, 'name' => 'Kitchen', 'description' => 'Modern kitchen', 'min_photos' => 8]),
            Room::create(['property_id' => $property2->id, 'name' => 'Bathroom', 'description' => 'Full bathroom', 'min_photos' => 8]),
        ];

        // Create Default Tasks
        $tasks = [
            // Bedroom tasks
            Task::create(['name' => 'Change bed linens', 'description' => 'Replace with fresh linens', 'room_type' => 'bedroom', 'is_default' => true]),
            Task::create(['name' => 'Dust all surfaces', 'description' => 'Including nightstands and dressers', 'room_type' => 'bedroom', 'is_default' => true]),
            Task::create(['name' => 'Vacuum floor', 'description' => 'Vacuum carpets and under bed', 'room_type' => 'bedroom', 'is_default' => true]),
            Task::create(['name' => 'Clean mirrors', 'description' => 'Wipe down all mirrors', 'room_type' => 'bedroom', 'is_default' => true]),
            
            // Bathroom tasks
            Task::create(['name' => 'Clean toilet', 'description' => 'Scrub and disinfect', 'room_type' => 'bathroom', 'is_default' => true]),
            Task::create(['name' => 'Clean shower/tub', 'description' => 'Remove soap scum and mildew', 'room_type' => 'bathroom', 'is_default' => true]),
            Task::create(['name' => 'Clean sink and counter', 'description' => 'Disinfect all surfaces', 'room_type' => 'bathroom', 'is_default' => true]),
            Task::create(['name' => 'Restock toiletries', 'description' => 'Check soap, shampoo, toilet paper', 'room_type' => 'bathroom', 'is_default' => true]),
            Task::create(['name' => 'Mop floor', 'description' => 'Clean and disinfect floor', 'room_type' => 'bathroom', 'is_default' => true]),
            
            // Kitchen tasks
            Task::create(['name' => 'Clean appliances', 'description' => 'Wipe down stove, microwave, fridge', 'room_type' => 'kitchen', 'is_default' => true]),
            Task::create(['name' => 'Clean countertops', 'description' => 'Disinfect all counter surfaces', 'room_type' => 'kitchen', 'is_default' => true]),
            Task::create(['name' => 'Clean sink', 'description' => 'Scrub and shine sink', 'room_type' => 'kitchen', 'is_default' => true]),
            Task::create(['name' => 'Sweep and mop floor', 'description' => 'Clean kitchen floor', 'room_type' => 'kitchen', 'is_default' => true]),
            Task::create(['name' => 'Take out trash', 'description' => 'Empty trash and replace liner', 'room_type' => 'kitchen', 'is_default' => true]),
            
            // Living room tasks
            Task::create(['name' => 'Dust furniture', 'description' => 'Dust all surfaces and shelves', 'room_type' => 'living', 'is_default' => true]),
            Task::create(['name' => 'Vacuum/clean floor', 'description' => 'Vacuum carpets or mop floors', 'room_type' => 'living', 'is_default' => true]),
            Task::create(['name' => 'Arrange furniture', 'description' => 'Straighten cushions and decor', 'room_type' => 'living', 'is_default' => true]),
            Task::create(['name' => 'Clean windows', 'description' => 'Wipe down windows and sills', 'room_type' => 'living', 'is_default' => true]),
        ];

        // Create sample checklists
        $checklist1 = Checklist::create([
            'property_id' => $property1->id,
            'housekeeper_id' => $housekeeper1->id,
            'assigned_by' => $owner->id,
            'scheduled_date' => now()->addDays(1),
            'status' => 'pending',
        ]);

        $checklist2 = Checklist::create([
            'property_id' => $property2->id,
            'housekeeper_id' => $housekeeper2->id,
            'assigned_by' => $owner->id,
            'scheduled_date' => now()->addDays(2),
            'status' => 'in_progress',
            'started_at' => now()->subHours(1),
            'gps_latitude' => 25.7743,
            'gps_longitude' => -80.1937,
            'gps_verified' => true,
        ]);

        // Create checklist items for in_progress checklist
        $tasks = Task::where('is_default', true)->get();
        foreach ($property2->rooms as $room) {
            foreach ($tasks as $task) {
                \App\Models\ChecklistItem::create([
                    'checklist_id' => $checklist2->id,
                    'room_id' => $room->id,
                    'task_id' => $task->id,
                    'is_completed' => rand(0, 1) == 1, // Random completion
                ]);
            }
        }

        // Seed photos for in_progress checklist
        $this->call(PhotoSeeder::class);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@housekeeping.com / password');
        $this->command->info('Owner: owner@housekeeping.com / password');
        $this->command->info('Housekeeper: maria@housekeeping.com / password');
        $this->command->info('Housekeeper Carlos: carlos@housekeeping.com / password');
    }
}
