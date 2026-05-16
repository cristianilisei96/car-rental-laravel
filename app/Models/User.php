<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CustomerDocument;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function approvedDriverLicense()
    {
        return $this->hasOne(CustomerDocument::class)
            ->where('document_type', 'driver_license')
            ->where('status', 'approved')
            ->latestOfMany();
    }

    public function approvedIdentityDocument()
    {
        return $this->hasOne(CustomerDocument::class)
            ->whereIn('document_type', ['id_card', 'passport'])
            ->where('status', 'approved')
            ->latestOfMany();
    }

    public function hasApprovedDriverLicense(): bool
    {
        return $this->documents()
            ->where('document_type', 'driver_license')
            ->where('status', 'approved')
            ->exists();
    }

    public function hasApprovedIdentityDocument(): bool
    {
        return $this->documents()
            ->whereIn('document_type', ['id_card', 'passport'])
            ->where('status', 'approved')
            ->exists();
    }

    public function isKycApproved(): bool
    {
        return $this->hasApprovedDriverLicense()
            && $this->hasApprovedIdentityDocument();
    }

    public function document()
    {
        return $this->hasOne(CustomerDocument::class)
            ->whereIn('status', ['pending', 'approved'])->latestOfMany();
    }

    public function approvedDocument()
    {
        return $this->hasOne(CustomerDocument::class)
            ->where('status', 'approved')
            ->latestOfMany();
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class);
    }

    public function favoriteCars()
    {
        return $this->belongsToMany(\App\Models\Car::class, 'favorites')
            ->withTimestamps();
    }

    public function hasFavoriteCar($carId): bool
    {
        return $this->favoriteCars()
            ->where('cars.id', $carId)
            ->exists();
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function hasCompleteCustomerProfile(): bool
    {
        return $this->customerProfile?->isComplete() ?? false;
    }
}
