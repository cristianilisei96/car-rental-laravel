<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarModel extends Model
{
    use HasFactory;

    // protected $table = 'cars_models';

    protected $fillable = ['brand_id', 'name'];

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }
}
