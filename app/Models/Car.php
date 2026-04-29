<?php

namespace App\Models;

use App\Models\CarImage;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'brand_id',
        'model_id',
        'color_id',
        'fuel_id',
        'seat_id',
        'type_id',
        'transmission_id',
        'status_id',
        'year',
        'price_per_day',
        'description',
    ];

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
        return $this->belongsTo(CarTransmission::class);
    }

    public function type()
    {
        return $this->belongsTo(CarType::class);
    }
}
