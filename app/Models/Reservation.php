<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'checkin_at',
        'checkout_at',
        'deleted_at',
    ];

    public function guests(): BelongsToMany {
        return $this->belongsToMany(Guest::class)
            ->withPivot('checkin_at','checkout_at','type'); //colunas da pivo
    }

    public function rooms(): BelongsToMany {
        return $this->belongsToMany(Room::class); //nao bota withPivot pq a pivo nao tem atributos proprios
    }
    public function services(): BelongsToMany {
        return $this->belongsToMany(Service::class); //nao bota withPivot pq a pivo nao tem atributos proprios
    }
}
