<?php

namespace Database\Seeders;

use App\Models\Cinema;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cinemas = [
            [
                'name' => 'Legend Cinema1',
                'address' => 'Aeon2 Mall',
                'city' => 'Phnom Penh',
                'phone' => '023111111',
            ],
            [
                'name' => 'Legend Cinema2',
                'address' => 'Chip Mong 271 Mall',
                'city' => 'Phnom Penh',
                'phone' => '023222222',
            ],
            [
                'name' => 'Sabay Cinema',
                'address' => 'Olympia Mall',
                'city' => 'Phnom Penh',
                'phone' => '023333333',
            ],
        ];

        foreach ($cinemas as $cinema) {
            Cinema::updateOrCreate(['name' => $cinema['name']], $cinema);
        }
    }
}
