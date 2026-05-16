<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarDiscountRuleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('car_discount_rules')->upsert([
            [
                'car_id' => 2,
                'min_days' => 7,
                'discount_per_day' => 20.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'car_id' => 2,
                'min_days' => 14,
                'discount_per_day' => 50.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'car_id' => 3,
                'min_days' => 7,
                'discount_per_day' => 20.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'car_id' => 3,
                'min_days' => 14,
                'discount_per_day' => 50.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'car_id' => 4,
                'min_days' => 7,
                'discount_per_day' => 5.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'car_id' => 4,
                'min_days' => 14,
                'discount_per_day' => 10.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['car_id', 'min_days'], [
            'discount_per_day',
            'is_active',
            'updated_at',
        ]);
    }
}
