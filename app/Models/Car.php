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
}
