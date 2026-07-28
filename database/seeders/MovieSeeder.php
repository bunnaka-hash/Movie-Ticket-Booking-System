<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Movie::insert([

        [
            'title'=>'Avengers: Endgame',
            'description'=>'Marvel Movie',
            'genre'=>'Action',
            'duration'=>181,
            'language'=>'English',
            'release_date'=>'2019-04-26',
            'poster'=>'endgame.jpg',
            'trailer_url'=>null,
            'rating'=>8.9,
            'status'=>'now_showing',
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        [
            'title'=>'Inside Out 2',
            'description'=>'Animation',
            'genre'=>'Animation',
            'duration'=>96,
            'language'=>'English',
            'release_date'=>'2024-06-14',
            'poster'=>'insideout2.jpg',
            'trailer_url'=>null,
            'rating'=>8.4,
            'status'=>'coming_soon',
            'created_at'=>now(),
            'updated_at'=>now()
        ]

    ]);
}
}
