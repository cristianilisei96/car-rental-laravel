<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTransmissions extends Model
{
    use HasFactory;

    protected $table = 'cars_transmissions';

    protected $fillable = ['name'];
}
