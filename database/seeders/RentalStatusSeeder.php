<?php

namespace Database\Seeders;

use App\Models\RentalStatus;
use Illuminate\Database\Seeder;

class RentalStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'id' => 1,
                'name' => 'Pending',
                'slug' => 'pending',
                'color' => 'yellow',
                'sort_order' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Approved',
                'slug' => 'approved',
                'color' => 'green',
                'sort_order' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Active',
                'slug' => 'active',
                'color' => 'purple',
                'sort_order' => 3,
            ],
            [
                'id' => 4,
                'name' => 'Completed',
                'slug' => 'completed',
                'color' => 'blue',
                'sort_order' => 4,
            ],
            [
                'id' => 5,
                'name' => 'Rejected',
                'slug' => 'rejected',
                'color' => 'red',
                'sort_order' => 5,
            ],
            [
                'id' => 6,
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'color' => 'gray',
                'sort_order' => 6,
            ],
        ];

        foreach ($statuses as $status) {
            RentalStatus::updateOrCreate(
                ['id' => $status['id']],
                $status
            );
        }
    }
}
