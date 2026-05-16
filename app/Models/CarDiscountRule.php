<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDiscountRule extends Model
{
    protected $fillable = [
        'car_id',
        'min_days',
        'discount_per_day',
        'is_active',
    ];

    protected $casts = [
        'discount_per_day' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
