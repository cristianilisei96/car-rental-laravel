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
