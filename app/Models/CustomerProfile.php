<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'address',
        'city',
        'country',
        'postal_code',
        'driver_license_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return filled($this->phone)
            && filled($this->date_of_birth)
            && filled($this->address)
            && filled($this->city)
            && filled($this->country)
            && filled($this->driver_license_number);
    }
}
