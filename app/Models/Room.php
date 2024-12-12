<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Room extends Model
{
    public $fillable = [
        'name',
        'description',
        'size',
        'max_adults',
        'max_children',
        'double_beds',
        'single_beds',
        'floor',
        'type',
        'number',
        'price'
    ];
  
    public function reservations(): BelongsToMany {
        return $this->belongsToMany(Reservation::class); //nao bota withPivot pq a pivo nao tem atributos proprios
    }
}
