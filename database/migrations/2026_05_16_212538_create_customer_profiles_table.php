<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('phone')->nullable();

            $table->date('date_of_birth')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Romania');
            $table->string('postal_code')->nullable();

            $table->string('driver_license_number')->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
