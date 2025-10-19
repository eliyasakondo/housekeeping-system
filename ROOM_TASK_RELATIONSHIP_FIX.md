# Room-Task Relationship Fix

## Issue
**Error**: `Call to undefined relationship [tasks] on model [App\Models\Room]`

When trying to load property details page, the system crashed because the Room model didn't have a `tasks()` relationship defined.

## Root Cause

The relationship between Rooms and Tasks was missing:
- ❌ Room model had no `tasks()` method
- ❌ Task model had no `rooms()` method  
- ❌ No `room_task` pivot table existed

The old system used a direct `room_id` foreign key on tasks (one-to-one), but the new Property Management System needs many-to-many (one room can have many tasks, one task can be assigned to many rooms).

## Solution Implemented

### 1. Created Pivot Table Migration
**File**: `database/migrations/2025_10_18_215644_create_room_task_table.php`

```php
Schema::create('room_task', function (Blueprint $table) {
    $table->id();
    $table->foreignId('room_id')->constrained()->onDelete('cascade');
    $table->foreignId('task_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    // Prevent duplicate assignments
    $table->unique(['room_id', 'task_id']);
});
```

**Features**:
- Foreign keys with cascade delete
- Unique constraint to prevent duplicate task assignments
- Timestamps for tracking

### 2. Added Relationship to Room Model
**File**: `app/Models/Room.php`

```php
public function tasks()
{
    return $this->belongsToMany(Task::class, 'room_task');
}
```

### 3. Added Relationship to Task Model
**File**: `app/Models/Task.php`

```php
public function rooms()
{
    return $this->belongsToMany(Room::class, 'room_task');
}
```

Note: Kept the old `room()` relationship for backward compatibility with existing checklist system.

## Database Changes

**New Table**: `room_task`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| room_id | bigint | Foreign key to rooms table |
| task_id | bigint | Foreign key to tasks table |
| created_at | timestamp | When assignment was made |
| updated_at | timestamp | When assignment was modified |

**Unique Index**: `room_task_room_id_task_id_unique`

## How It Works Now

### Before (One-to-One) ❌
```
Task Table:
- id
- name
- room_id ← Only ONE room per task
```

### After (Many-to-Many) ✅
```
Rooms Table          room_task (Pivot)         Tasks Table
-----------          -----------------         -----------
id: 1                room_id: 1, task_id: 1    id: 1
name: Bedroom        room_id: 1, task_id: 2    name: Vacuum
                     room_id: 2, task_id: 1    
id: 2                room_id: 2, task_id: 3    id: 2
name: Kitchen                                  name: Dust

                                               id: 3
                                               name: Mop
```

**Result**: 
- Bedroom has 2 tasks (Vacuum, Dust)
- Kitchen has 2 tasks (Vacuum, Mop)
- Vacuum task is in 2 rooms (Bedroom, Kitchen)

## Usage in Code

### Attach Tasks to Room
```php
$room->tasks()->attach($taskId);
$room->tasks()->attach([1, 2, 3]); // Multiple
$room->tasks()->syncWithoutDetaching([1, 2, 3]); // Add without removing existing
```

### Detach Tasks from Room
```php
$room->tasks()->detach($taskId);
$room->tasks()->detach([1, 2]); // Multiple
$room->tasks()->sync([]); // Remove all
```

### Get All Tasks for a Room
```php
$tasks = $room->tasks; // Collection of Task models
$taskNames = $room->tasks->pluck('name'); // ['Vacuum', 'Dust', 'Mop']
```

### Get All Rooms for a Task
```php
$rooms = $task->rooms; // Collection of Room models
```

### Check if Room Has Task
```php
if ($room->tasks->contains($taskId)) {
    // Room has this task
}
```

## Migration Command

```bash
php artisan migrate
```

**Output**:
```
INFO  Running migrations.
2025_10_18_215644_create_room_task_table ........ 112.83ms DONE
```

## Testing Checklist

- [x] Room model has `tasks()` relationship
- [x] Task model has `rooms()` relationship
- [x] `room_task` table created
- [x] Property details page loads without error
- [x] Can view rooms and their tasks
- [ ] Can attach tasks to rooms
- [ ] Can detach tasks from rooms
- [ ] Duplicate prevention works (unique constraint)
- [ ] Cascade delete works (deleting room removes pivot records)

## Files Modified

1. **app/Models/Room.php** - Added `tasks()` relationship
2. **app/Models/Task.php** - Added `rooms()` relationship  
3. **database/migrations/2025_10_18_215644_create_room_task_table.php** - Created pivot table

## Status

✅ **Fixed** - Relationship error resolved
✅ **Migrated** - Database table created
✅ **Tested** - Property page loads successfully

**Date**: October 19, 2025
