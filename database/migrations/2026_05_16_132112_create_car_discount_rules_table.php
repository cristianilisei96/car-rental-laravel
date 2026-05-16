<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_discount_rules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('min_days');

            $table->decimal('discount_per_day', 10, 2)->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['car_id', 'min_days']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_discount_rules');
    }
};
