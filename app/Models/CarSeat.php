<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSeat extends Model
{
    use HasFactory;

    // protected $table = 'cars_seats';

    protected $fillable = ['seats'];
}
