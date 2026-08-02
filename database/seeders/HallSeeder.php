<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Halls are attached to their cinema by name instead of a hard-coded id,
     * so the seeder still works when the cinemas table is not starting at 1.
     */
    public function run(): void
    {
        $halls = [
            'Legend Cinema1' => [
                ['name' => 'Hall 1', 'total_seats' => 120],
                ['name' => 'Hall 2', 'total_seats' => 100],
                ['name' => 'VIP Hall', 'total_seats' => 40],
            ],
            'Legend Cinema2' => [
                ['name' => 'Hall 1', 'total_seats' => 100],
                ['name' => 'Hall 2', 'total_seats' => 120],
                ['name' => 'VIP Hall', 'total_seats' => 50],
            ],
            'Sabay Cinema' => [
                ['name' => 'Hall 1', 'total_seats' => 96],
                ['name' => 'Hall 2', 'total_seats' => 90],
                ['name' => 'VIP Hall', 'total_seats' => 45],
            ],
        ];

        foreach ($halls as $cinemaName => $cinemaHalls) {
            $cinema = Cinema::where('name', $cinemaName)->first();

            if (! $cinema) {
                $this->command?->warn("Cinema [{$cinemaName}] not found, skipping its halls.");
                continue;
            }

            foreach ($cinemaHalls as $hall) {
                Hall::updateOrCreate(
                    ['cinema_id' => $cinema->id, 'name' => $hall['name']],
                    $hall + ['cinema_id' => $cinema->id]
                );
            }
        }
    }
}
