<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsImagesTable extends Migration
{
    public function up()
    {
        Schema::create('cars_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_main')->default(false); // imagine principală
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars_images');
    }
};
