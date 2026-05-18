<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dateTime('actual_return_at')->nullable()->after('return_time');
            $table->unsignedInteger('return_mileage')->nullable()->after('actual_return_at');
            $table->string('fuel_level')->nullable()->after('return_mileage');
            $table->text('return_notes')->nullable()->after('fuel_level');
            $table->text('damage_notes')->nullable()->after('return_notes');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'actual_return_at',
                'return_mileage',
                'fuel_level',
                'return_notes',
                'damage_notes',
            ]);
        });
    }
};
