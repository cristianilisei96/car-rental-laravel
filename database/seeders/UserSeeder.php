<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Cristian Ilisei',
            'email' => 'cristianilisei96@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => '1', // role column from previous migration
        ]);

        // Customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => '0',
        ]);
    }
}
