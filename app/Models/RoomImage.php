<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomImage extends Model
{
    protected $fillable = [
        'room_id',
        'featured',
        'description',
        'alt'
    ];

    public function room(): BelongsTo{
        return $this->belongsTo(Room::class);
    }
}
