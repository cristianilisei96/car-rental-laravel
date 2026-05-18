<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'status_id',
        'pickup_date',
        'return_date',
        'pickup_time',
        'return_time',
        'total_days',
        'price_per_day',
        'discount_per_day',
        'subtotal_price',
        'total_discount',
        'total_price',
        'payment_method',
        'payment_status',
        'actual_return_at',
        'return_mileage',
        'fuel_level',
        'return_notes',
        'damage_notes',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'return_date' => 'date',
        'price_per_day' => 'decimal:2',
        'discount_per_day' => 'decimal:2',
        'subtotal_price' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'actual_return_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function status()
    {
        return $this->belongsTo(RentalStatus::class, 'status_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(RentalEvent::class)->latest();
    }
}
