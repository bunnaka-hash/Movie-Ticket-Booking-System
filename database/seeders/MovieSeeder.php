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
                'title'=>'Inside Out 2',
                'description'=>'A Pixar animation adventure.',
                'genre'=>'Animation',
                'duration'=>96,
                'language'=>'English',
                'release_date'=>'2024-06-14',
                'poster'=>'insideout2.jpg',
                'trailer_url'=>null,
                'rating'=>8.4,
                'status'=>'now_showing',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'title'=>'Deadpool & Wolverine',
                'description'=>'Marvel superhero action movie.',
                'genre'=>'Action',
                'duration'=>128,
                'language'=>'English',
                'release_date'=>'2024-07-26',
                'poster'=>'deadpool.jpg',
                'trailer_url'=>null,
                'rating'=>8.0,
                'status'=>'now_showing',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'title'=>'Avatar 3',
                'description'=>'The next Pandora adventure.',
                'genre'=>'Sci-Fi',
                'duration'=>180,
                'language'=>'English',
                'release_date'=>'2025-12-19',
                'poster'=>'avatar3.jpg',
                'trailer_url'=>null,
                'rating'=>8.8,
                'status'=>'coming_soon',
                'created_at'=>now(),
                'updated_at'=>now()
            ],


            [
                'title'=>'Kung Fu Panda 4',
                'description'=>'Po returns for a new mission.',
                'genre'=>'Animation',
                'duration'=>94,
                'language'=>'English',
                'release_date'=>'2024-03-08',
                'poster'=>'kungfu4.jpg',
                'trailer_url'=>null,
                'rating'=>7.6,
                'status'=>'now_showing',
                'created_at'=>now(),
                'updated_at'=>now()
            ],


            [
                'title'=>'The Batman',
                'description'=>'Batman fights crime in Gotham.',
                'genre'=>'Action',
                'duration'=>176,
                'language'=>'English',
                'release_date'=>'2022-03-04',
                'poster'=>'batman.jpg',
                'trailer_url'=>null,
                'rating'=>8.2,
                'status'=>'now_showing',
                'created_at'=>now(),
                'updated_at'=>now()
            ],


    ]);
}
}
