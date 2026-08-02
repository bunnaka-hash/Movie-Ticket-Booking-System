<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Support\SeatLayout;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seats are generated per hall from that hall's `total_seats`, so the
     * seat count in the seats table always matches the hall record. The
     * layout itself lives in App\Support\SeatLayout, shared with the admin
     * hall CRUD.
     */
    public function run(): void
    {
        foreach (Hall::all() as $hall) {
            SeatLayout::generate($hall);
        }
    }
}
