<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTables();

        $this->call([
            UserSeeder::class,
            CinemaSeeder::class,
            HallSeeder::class,
            SeatSeeder::class,
            MovieSeeder::class,
            ShowtimeSeeder::class,
            BookingSeeder::class,
        ]);
    }

    /**
     * Wipe the seeded tables so `db:seed` can be run repeatedly without
     * tripping the unique indexes on users.email, seats and booking_details.
     */
    private function truncateTables(): void
    {
        $tables = [
            'booking_details',
            'bookings',
            'showtimes',
            'seats',
            'halls',
            'cinemas',
            'movies',
            'users',
        ];

        Schema::disableForeignKeyConstraints();

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
