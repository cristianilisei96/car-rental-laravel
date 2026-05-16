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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('pickup_date');
            $table->date('return_date');

            $table->unsignedInteger('total_days');

            $table->decimal('price_per_day', 10, 2);
            $table->decimal('discount_per_day', 10, 2)->default(0);
            $table->decimal('subtotal_price', 10, 2);
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);

            $table->foreignId('status_id')
                ->constrained('rental_statuses');

            $table->enum('payment_method', [
                'cash',
                'card',
            ])->default('cash');

            $table->enum('payment_status', [
                'unpaid',
                'pending',
                'paid',
                'refunded',
            ])->default('unpaid');

            $table->timestamps();

            $table->index(['user_id', 'status_id']);
            $table->index(['car_id', 'pickup_date', 'return_date']);
            $table->index(['payment_method', 'payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
