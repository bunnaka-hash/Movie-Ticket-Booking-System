<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Cinema::insert([
        [
            'name' => 'Legend Cinema',
            'address' => 'City Mall',
            'city' => 'Phnom Penh',
            'phone' => '023111111',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Major Cineplex',
            'address' => 'AEON Mall',
            'city' => 'Phnom Penh',
            'phone' => '023222222',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
}
}
