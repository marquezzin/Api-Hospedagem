<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    public $fillable = [
        'name',
        'price',
        'description'
    ];

    public function reservations(): BelongsToMany {
        return $this->belongsToMany(Reservation::class); //nao bota withPivot pq a pivo nao tem atributos proprios
    }
}
