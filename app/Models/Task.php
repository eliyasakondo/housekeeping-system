<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'room_type',
        'is_default',
        'property_id',
        // 'room_id', // Deprecated - now using many-to-many via room_task pivot table
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Deprecated: Old single-room relationship (kept for backward compatibility with old checklists)
    // public function room()
    // {
    //     return $this->belongsTo(Room::class);
    // }

    // NEW: Many-to-many relationship - one task can be assigned to multiple rooms
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_task');
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
