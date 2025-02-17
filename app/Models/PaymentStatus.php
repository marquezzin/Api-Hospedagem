<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentStatus extends Model
{
    protected $fillable = [
        'payment_id',
        'status',
    ];

    public function payment(): BelongsTo{
        return $this->belongsTo(Payment::class);
    }
}
