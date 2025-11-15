<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create a default branch if none exists
        $branch = \App\Models\Branch::firstOrCreate(
            ['code' => 'BR-001'],
            [
                'name' => 'Main Branch',
                'address' => '123 Business Street',
                'city' => 'Business City',
                'postal_code' => '12345',
                'country' => 'LK',
                'currency' => 'LKR',
                'phone' => '+1234567890',
                'email' => 'branch@business.com',
                'is_active' => true,
                'is_main' => true,
            ]
        );

        \App\Models\Warehouse::create([
            'branch_id' => $branch->id,
            'name' => 'Main Warehouse',
            'code' => 'WH-001',
            'location' => '123 Business Street, Business City',
            'phone' => '+1234567890',
            'manager_name' => 'John Manager',
            'is_active' => true,
        ]);
    }
}
