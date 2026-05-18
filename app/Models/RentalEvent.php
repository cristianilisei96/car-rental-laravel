<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalEvent extends Model
{
    protected $fillable = [
        'rental_id',
        'user_id',
        'type',
        'message',
        'old_status_id',
        'new_status_id',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function oldStatus(): BelongsTo
    {
        return $this->belongsTo(RentalStatus::class, 'old_status_id');
    }

    public function newStatus(): BelongsTo
    {
        return $this->belongsTo(RentalStatus::class, 'new_status_id');
    }
}
