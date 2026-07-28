<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Showtime::insert([

        [
            'movie_id'=>1,
            'hall_id'=>1,
            'start_time'=>'2026-08-01 10:00:00',
            'end_time'=>'2026-08-01 13:01:00',
            'price'=>6.50,
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        [
            'movie_id'=>2,
            'hall_id'=>2,
            'start_time'=>'2026-08-01 14:00:00',
            'end_time'=>'2026-08-01 15:36:00',
            'price'=>5.50,
            'created_at'=>now(),
            'updated_at'=>now()
        ]

    ]);
}
}
