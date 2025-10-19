<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'housekeeper_id',
        'assigned_by',
        'scheduled_date',
        'scheduled_time',
        'status',
        'workflow_step',
        'current_room_id',
        'started_at',
        'completed_at',
        'tasks_completed_at',
        'inventory_completed_at',
        'gps_latitude',
        'gps_longitude',
        'gps_verified',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'tasks_completed_at' => 'datetime',
        'inventory_completed_at' => 'datetime',
        'gps_verified' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function housekeeper()
    {
        return $this->belongsTo(User::class, 'housekeeper_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function currentRoom()
    {
        return $this->belongsTo(Room::class, 'current_room_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'current_room_id');
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'secondary',
            'in_progress' => 'primary',
            'completed' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
