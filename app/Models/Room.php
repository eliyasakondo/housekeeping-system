<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'description',
        'min_photos',
        'is_default',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'room_task');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function checklistItems()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
