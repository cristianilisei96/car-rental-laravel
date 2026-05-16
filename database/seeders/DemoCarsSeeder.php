<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoCarsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('cars')->upsert([
            [
                'id' => 2,
                'name' => 'Volvo EX90 Full Electric',
                'description' => 'Descriptionnn',
                'price_per_day' => 200.00,
                'year' => 2026,
                'brand_id' => 43,
                'model_id' => 1,
                'type_id' => 1,
                'color_id' => 4,
                'fuel_id' => 4,
                'seat_id' => 4,
                'transmission_id' => 2,
                'status_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Volvo EX60',
                'description' => 'Description',
                'price_per_day' => 180.00,
                'year' => 2026,
                'brand_id' => 43,
                'model_id' => 2,
                'type_id' => 1,
                'color_id' => 4,
                'fuel_id' => 4,
                'seat_id' => 4,
                'transmission_id' => 2,
                'status_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Dacia Logan 2022',
                'description' => null,
                'price_per_day' => 30.00,
                'year' => 2022,
                'brand_id' => 9,
                'model_id' => 8,
                'type_id' => 4,
                'color_id' => 1,
                'fuel_id' => 1,
                'seat_id' => 3,
                'transmission_id' => 1,
                'status_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['id'], [
            'name',
            'description',
            'price_per_day',
            'year',
            'brand_id',
            'model_id',
            'type_id',
            'color_id',
            'fuel_id',
            'seat_id',
            'transmission_id',
            'status_id',
            'updated_at',
        ]);

        DB::table('car_images')->upsert([
            ['id' => 11, 'car_id' => 2, 'image_path' => 'cars/tS35rZLCdBouFdG0DZ7vWH4EIG2a8CLBpoUTvdAy.jpg', 'is_main' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'car_id' => 2, 'image_path' => 'cars/ytZE6qGCxi915fv5Is7Zm2BEo265lXlkubr4LrzP.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 13, 'car_id' => 2, 'image_path' => 'cars/fIhErIFwdECTmk6UOcU3ZFhG8xJnYW2nHPLqkv4B.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 14, 'car_id' => 2, 'image_path' => 'cars/d8v2ho44hnk7cnGDqfvqaUPZzVtllMAJusdzJOnL.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 15, 'car_id' => 2, 'image_path' => 'cars/JLveLtNWQR7ZDlsql3PQcdQ9bJR4985EICI8odOR.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 16, 'car_id' => 2, 'image_path' => 'cars/SlkuZNSoIRjhcOcE6g5w5ZswAMVH48geKuVNbXd4.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 17, 'car_id' => 2, 'image_path' => 'cars/QWwhZYUPpFV5YzMuPksFY0BZiilz9kRw9RI7y0bt.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],

            ['id' => 20, 'car_id' => 3, 'image_path' => 'cars/FrLOz8Hxgownw5nSgItX9hglA0sTPSaDhGqH0Mph.jpg', 'is_main' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 21, 'car_id' => 3, 'image_path' => 'cars/q9SxLV74li0lZ9wUBecrwmQs7z1Y7CMsoDRYGVaI.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 22, 'car_id' => 3, 'image_path' => 'cars/xc98iXS8vb2S5RNDlMQ7WPYLXMIaEktf2TsJVMhm.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 23, 'car_id' => 3, 'image_path' => 'cars/PQmuhD4O2UMfdReAhFGidkEv19YbJGleLDMoTInR.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 24, 'car_id' => 3, 'image_path' => 'cars/gzvgi671E0FKEDPkhn3vmQHgnURsiPRq6Bg2FOYE.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 25, 'car_id' => 3, 'image_path' => 'cars/qmNoVPDuc55O9HnNzpjllSbVLBEjNnzWhXVuigKR.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 26, 'car_id' => 3, 'image_path' => 'cars/uB4astaFmB8UQlIgJosP8VdvyO9br3XiSpKEoTCy.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 27, 'car_id' => 3, 'image_path' => 'cars/Lth4qeXIDcxXBYq7PJCFqx6zkFP0lnGXclBKRb1V.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 28, 'car_id' => 3, 'image_path' => 'cars/1BECV2FqeRbo2K59Q08CkN8CrGnIzREFNpxmc74D.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 29, 'car_id' => 3, 'image_path' => 'cars/Qn6T3he4PlgBNox9VqaaatelC2c2BERTOvEW1Fe4.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],

            ['id' => 30, 'car_id' => 4, 'image_path' => 'cars/Ocyd2QeeL0q52anvqdxTB0ZWxE5zWxk6s9ziO98o.jpg', 'is_main' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 31, 'car_id' => 4, 'image_path' => 'cars/Ml8TIJOMdqJK5orXPTnlZRUiwamB4xLnAWjAvcs6.jpg', 'is_main' => 0, 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], [
            'car_id',
            'image_path',
            'is_main',
            'updated_at',
        ]);
    }
}
