<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsAttributesSeeder extends Seeder
{
    public function run(): void
    {
        // Statuses
        DB::table('car_statuses')->insert([
            [
                'name' => 'Available',
                'created_at' => now(),
            ],
            [
                'name' => 'Rented',
                'created_at' => now(),
            ],
            [
                'name' => 'In service',
                'created_at' => now(),
            ],
        ]);

        // Brands
        DB::table('car_brands')->insert([
            ['name' => 'Abarth', 'created_at' => now()],
            ['name' => 'Alfa Romeo', 'created_at' => now()],
            ['name' => 'Audi', 'created_at' => now()],
            ['name' => 'BMW', 'created_at' => now()],
            ['name' => 'Chevrolet', 'created_at' => now()],
            ['name' => 'Chrysler', 'created_at' => now()],
            ['name' => 'Citroen', 'created_at' => now()],
            ['name' => 'Cupra', 'created_at' => now()],
            ['name' => 'Dacia', 'created_at' => now()],
            ['name' => 'Fiat', 'created_at' => now()],
            ['name' => 'Ford', 'created_at' => now()],
            ['name' => 'Honda', 'created_at' => now()],
            ['name' => 'Hyundai', 'created_at' => now()],
            ['name' => 'Infiniti', 'created_at' => now()],
            ['name' => 'Isuzu', 'created_at' => now()],
            ['name' => 'Jaecoo', 'created_at' => now()],
            ['name' => 'Jaguar', 'created_at' => now()],
            ['name' => 'Jeep', 'created_at' => now()],
            ['name' => 'Kia', 'created_at' => now()],
            ['name' => 'Lancia', 'created_at' => now()],
            ['name' => 'Land Rover', 'created_at' => now()],
            ['name' => 'Lexus', 'created_at' => now()],
            ['name' => 'Mazda', 'created_at' => now()],
            ['name' => 'Mercedes-Benz', 'created_at' => now()],
            ['name' => 'Mini', 'created_at' => now()],
            ['name' => 'Mitsubishi', 'created_at' => now()],
            ['name' => 'Microcar', 'created_at' => now()],
            ['name' => 'Nissan', 'created_at' => now()],
            ['name' => 'Opel', 'created_at' => now()],
            ['name' => 'Peugeot', 'created_at' => now()],
            ['name' => 'Renault', 'created_at' => now()],
            ['name' => 'Rover', 'created_at' => now()],
            ['name' => 'Saab', 'created_at' => now()],
            ['name' => 'Seat', 'created_at' => now()],
            ['name' => 'Skoda', 'created_at' => now()],
            ['name' => 'Smart', 'created_at' => now()],
            ['name' => 'Subaru', 'created_at' => now()],
            ['name' => 'Suzuki', 'created_at' => now()],
            ['name' => 'Tesla', 'created_at' => now()],
            ['name' => 'Tata', 'created_at' => now()],
            ['name' => 'Toyota', 'created_at' => now()],
            ['name' => 'Volkswagen', 'created_at' => now()],
            ['name' => 'Volvo', 'created_at' => now()],
        ]);

        // Colors
        DB::table('car_colors')->insert([
            ['name' => 'White', 'created_at' => now()],
            ['name' => 'Black', 'created_at' => now()],
            ['name' => 'Silver', 'created_at' => now()],
            ['name' => 'Gray', 'created_at' => now()],
            ['name' => 'Red', 'created_at' => now()],
            ['name' => 'Blue', 'created_at' => now()],
            ['name' => 'Green', 'created_at' => now()],
            ['name' => 'Beige', 'created_at' => now()],
            ['name' => 'Orange', 'created_at' => now()],
            ['name' => 'Purple', 'created_at' => now()],
            ['name' => 'Bronze', 'created_at' => now()],
            ['name' => 'Turquoise', 'created_at' => now()],
        ]);

        // Fuels
        DB::table('car_fuels')->insert([
            ['name' => 'Gasolin', 'created_at' => now()],
            ['name' => 'Diesel', 'created_at' => now()],
            ['name' => 'Hybrid', 'created_at' => now()],
            ['name' => 'Electric', 'created_at' => now()],
        ]);

        // Models
        DB::table('car_models')->insert([
            ['id' => 1, 'brand_id' => 43, 'name' => 'EX90', 'created_at' => now()],
            ['id' => 2, 'brand_id' => 43, 'name' => 'EX60', 'created_at' => now()],
            ['id' => 3, 'brand_id' => 43, 'name' => 'EX40', 'created_at' => now()],
            ['id' => 4, 'brand_id' => 43, 'name' => 'EX30', 'created_at' => now()],
            ['id' => 5, 'brand_id' => 43, 'name' => 'XC90', 'created_at' => now()],
            ['id' => 6, 'brand_id' => 43, 'name' => 'XC60', 'created_at' => now()],
            ['id' => 7, 'brand_id' => 43, 'name' => 'XC30', 'created_at' => now()],

            ['id' => 8, 'brand_id' => 9, 'name' => 'Logan', 'created_at' => now()],
            ['id' => 9, 'brand_id' => 9, 'name' => 'Duster', 'created_at' => now()],
            ['id' => 10, 'brand_id' => 9, 'name' => 'Sandero', 'created_at' => now()],
            ['id' => 11, 'brand_id' => 9, 'name' => 'Jogger', 'created_at' => now()],

            ['id' => 12, 'brand_id' => 42, 'name' => 'Golf', 'created_at' => now()],
            ['id' => 13, 'brand_id' => 42, 'name' => 'Golf V', 'created_at' => now()],
            ['id' => 14, 'brand_id' => 42, 'name' => 'Passat', 'created_at' => now()],
            ['id' => 15, 'brand_id' => 42, 'name' => 'Tiguan', 'created_at' => now()],

            ['id' => 16, 'brand_id' => 35, 'name' => 'Octavia', 'created_at' => now()],
            ['id' => 17, 'brand_id' => 35, 'name' => 'Superb', 'created_at' => now()],
            ['id' => 18, 'brand_id' => 35, 'name' => 'Kodiaq', 'created_at' => now()],

            ['id' => 19, 'brand_id' => 4, 'name' => 'Series 3', 'created_at' => now()],
            ['id' => 20, 'brand_id' => 4, 'name' => 'X5', 'created_at' => now()],

            ['id' => 21, 'brand_id' => 3, 'name' => 'A4', 'created_at' => now()],
            ['id' => 22, 'brand_id' => 3, 'name' => 'A6', 'created_at' => now()],
            ['id' => 23, 'brand_id' => 3, 'name' => 'Q5', 'created_at' => now()],

            ['id' => 24, 'brand_id' => 24, 'name' => 'C-Class', 'created_at' => now()],
            ['id' => 25, 'brand_id' => 24, 'name' => 'GLC', 'created_at' => now()],

            ['id' => 26, 'brand_id' => 41, 'name' => 'Corolla', 'created_at' => now()],
            ['id' => 27, 'brand_id' => 41, 'name' => 'RAV4', 'created_at' => now()],

            ['id' => 28, 'brand_id' => 31, 'name' => 'Clio', 'created_at' => now()],
            ['id' => 29, 'brand_id' => 31, 'name' => 'Megane', 'created_at' => now()],

            ['id' => 30, 'brand_id' => 11, 'name' => 'Focus', 'created_at' => now()],
            ['id' => 31, 'brand_id' => 11, 'name' => 'Kuga', 'created_at' => now()],

            ['id' => 32, 'brand_id' => 39, 'name' => 'Model 3', 'created_at' => now()],
            ['id' => 33, 'brand_id' => 39, 'name' => 'Model X', 'created_at' => now()],
            ['id' => 34, 'brand_id' => 39, 'name' => 'Model Y', 'created_at' => now()],
        ]);

        // Seats
        DB::table('car_seats')->insert([
            [
                'seats' => 2,
                'created_at' => now(),
            ],
            [
                'seats' => 4,
                'created_at' => now(),
            ],
            [
                'seats' => 5,
                'created_at' => now(),
            ],
            [
                'seats' => 7,
                'created_at' => now(),
            ],
        ]);

        // Transmissions
        DB::table('car_transmissions')->insert([
            [
                'name' => 'Manual',
                'created_at' => now(),
            ],
            [
                'name' => 'Automat',
                'created_at' => now(),
            ],
            [
                'name' => 'Semi-automat',
                'created_at' => now(),
            ],
        ]);

        // Types
        DB::table('car_types')->insert([
            [
                'name' => 'SUV',
                'created_at' => now(),
            ],
            [
                'name' => 'City',
                'created_at' => now(),
            ],
            [
                'name' => 'Hatchback',
                'created_at' => now(),
            ],
            [
                'name' => 'Sedan',
                'created_at' => now(),
            ],
            [
                'name' => 'Coupe',
                'created_at' => now(),
            ],
        ]);
    }
}
