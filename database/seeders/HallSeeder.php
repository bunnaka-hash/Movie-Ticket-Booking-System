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

        [
            'cinema_id'=>1,
            'name'=>'Hall 1',
            'total_seats'=>133,
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        [
            'cinema_id'=>1,
            'name'=>'Hall 2',
            'total_seats'=>133,
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        [
            'cinema_id'=>2,
            'name'=>'Hall 1',
            'total_seats'=>161,
            'created_at'=>now(),
            'updated_at'=>now()
        ]

    ]);
}
}
