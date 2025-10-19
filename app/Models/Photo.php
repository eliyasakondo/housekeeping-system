<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'room_id',
        'file_path',
        'original_filename',
        'taken_at',
        'gps_latitude',
        'gps_longitude',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
