<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Hall::insert([

        // Legend Cinema1
            [
                'cinema_id'=>1,
                'name'=>'Hall 1',
                'total_seats'=>120,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>1,
                'name'=>'Hall 2',
                'total_seats'=>100,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>1,
                'name'=>'VIP Hall',
                'total_seats'=>40,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            // legend Cinema2
            [
                'cinema_id'=>2,
                'name'=>'Hall 1',
                'total_seats'=>100,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>2,
                'name'=>'Hall 2',
                'total_seats'=>120,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>2,
                'name'=>'VIP Hall',
                'total_seats'=>50,
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            // Sabay Cinema
            [
                'cinema_id'=>3,
                'name'=>'Hall 1',
                'total_seats'=>96,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>3,
                'name'=>'Hall 2',
                'total_seats'=>90,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'cinema_id'=>3,
                'name'=>'VIP Hall',
                'total_seats'=>45,
                'created_at'=>now(),
                'updated_at'=>now()
            ],

    ]);
}
}
