<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'checklist_id',
        'item_name',
        'quantity',
        'is_available',
        'notes',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
