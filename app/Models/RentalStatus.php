<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalStatus extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'color',
        'sort_order',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'status_id');
    }
}
