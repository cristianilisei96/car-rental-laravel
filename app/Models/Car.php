<?php

namespace App\Models;

use App\Models\CarImage;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(CarImage::class)->where('is_main', true);
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function color()
    {
        return $this->belongsTo(CarColor::class);
    }

    public function fuel()
    {
        return $this->belongsTo(CarFuel::class);
    }

    public function seat()
    {
        return $this->belongsTo(CarSeat::class);
    }

    public function status()
    {
        return $this->belongsTo(CarStatus::class);
    }

    public function transmission()
    {
        return $this->belongsTo(CarTransmissions::class);
    }

    public function type()
    {
        return $this->belongsTo(CarTypes::class);
    }
}
