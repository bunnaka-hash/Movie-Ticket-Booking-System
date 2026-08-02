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

                // ===== TODAY (2026-08-02) =====

        // Legend Cinema1 - Hall 1
        [
            'movie_id'=>1,
            'hall_id'=>1,
            'start_time'=>'2026-08-02 10:00:00',
            'end_time'=>'2026-08-02 11:36:00',
            'price'=>5.50,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>1,
            'hall_id'=>1,
            'start_time'=>'2026-08-02 14:00:00',
            'end_time'=>'2026-08-02 15:36:00',
            'price'=>5.50,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>1,
            'hall_id'=>1,
            'start_time'=>'2026-08-02 19:00:00',
            'end_time'=>'2026-08-02 20:36:00',
            'price'=>5.50,
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        // Legend Cinema2 - Hall 4
        [
            'movie_id'=>2,
            'hall_id'=>4,
            'start_time'=>'2026-08-02 11:00:00',
            'end_time'=>'2026-08-02 13:08:00',
            'price'=>6.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>2,
            'hall_id'=>4,
            'start_time'=>'2026-08-02 15:00:00',
            'end_time'=>'2026-08-02 17:08:00',
            'price'=>6.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>2,
            'hall_id'=>4,
            'start_time'=>'2026-08-02 20:00:00',
            'end_time'=>'2026-08-02 22:08:00',
            'price'=>6.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],

        // Sabay Cinema - Hall 7
        [
            'movie_id'=>3,
            'hall_id'=>7,
            'start_time'=>'2026-08-02 10:30:00',
            'end_time'=>'2026-08-02 13:30:00',
            'price'=>7.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>3,
            'hall_id'=>7,
            'start_time'=>'2026-08-02 15:00:00',
            'end_time'=>'2026-08-02 18:00:00',
            'price'=>7.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
            'movie_id'=>3,
            'hall_id'=>7,
            'start_time'=>'2026-08-02 19:30:00',
            'end_time'=>'2026-08-02 22:30:00',
            'price'=>7.00,
            'created_at'=>now(),
            'updated_at'=>now()
        ],
        [
    // ===== 2026-08-03 =====
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-03 10:00:00','end_time'=>'2026-08-03 11:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-03 14:00:00','end_time'=>'2026-08-03 15:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-03 19:00:00','end_time'=>'2026-08-03 20:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],

    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-03 11:00:00','end_time'=>'2026-08-03 13:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-03 15:00:00','end_time'=>'2026-08-03 17:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-03 20:00:00','end_time'=>'2026-08-03 22:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],

    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-03 10:30:00','end_time'=>'2026-08-03 13:30:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-03 15:00:00','end_time'=>'2026-08-03 18:00:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-03 19:30:00','end_time'=>'2026-08-03 22:30:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],

    // ===== 2026-08-04 =====
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-04 10:00:00','end_time'=>'2026-08-04 11:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-04 14:00:00','end_time'=>'2026-08-04 15:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-04 19:00:00','end_time'=>'2026-08-04 20:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],

    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-04 11:00:00','end_time'=>'2026-08-04 13:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-04 15:00:00','end_time'=>'2026-08-04 17:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-04 20:00:00','end_time'=>'2026-08-04 22:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],

    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-04 10:30:00','end_time'=>'2026-08-04 13:30:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-04 15:00:00','end_time'=>'2026-08-04 18:00:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>7,'start_time'=>'2026-08-04 19:30:00','end_time'=>'2026-08-04 22:30:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],

    // ===== 2026-08-05 =====
    ['movie_id'=>4,'hall_id'=>2,'start_time'=>'2026-08-05 10:00:00','end_time'=>'2026-08-05 11:34:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>4,'hall_id'=>2,'start_time'=>'2026-08-05 14:00:00','end_time'=>'2026-08-05 15:34:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>4,'hall_id'=>2,'start_time'=>'2026-08-05 19:00:00','end_time'=>'2026-08-05 20:34:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],

    ['movie_id'=>5,'hall_id'=>5,'start_time'=>'2026-08-05 11:00:00','end_time'=>'2026-08-05 13:56:00','price'=>6.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>5,'hall_id'=>5,'start_time'=>'2026-08-05 15:00:00','end_time'=>'2026-08-05 17:56:00','price'=>6.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>5,'hall_id'=>5,'start_time'=>'2026-08-05 20:00:00','end_time'=>'2026-08-05 22:56:00','price'=>6.50,'created_at'=>now(),'updated_at'=>now()],

    // ===== 2026-08-06 =====
    ['movie_id'=>1,'hall_id'=>3,'start_time'=>'2026-08-06 10:00:00','end_time'=>'2026-08-06 11:36:00','price'=>8.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>6,'start_time'=>'2026-08-06 14:00:00','end_time'=>'2026-08-06 16:08:00','price'=>8.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>9,'start_time'=>'2026-08-06 19:00:00','end_time'=>'2026-08-06 22:00:00','price'=>9.00,'created_at'=>now(),'updated_at'=>now()],

    // ===== 2026-08-07 =====
    ['movie_id'=>1,'hall_id'=>1,'start_time'=>'2026-08-07 10:00:00','end_time'=>'2026-08-07 11:36:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>2,'hall_id'=>4,'start_time'=>'2026-08-07 15:00:00','end_time'=>'2026-08-07 17:08:00','price'=>6.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>5,'hall_id'=>7,'start_time'=>'2026-08-07 20:00:00','end_time'=>'2026-08-07 22:56:00','price'=>6.50,'created_at'=>now(),'updated_at'=>now()],

    // ===== 2026-08-08 =====
    ['movie_id'=>4,'hall_id'=>2,'start_time'=>'2026-08-08 10:00:00','end_time'=>'2026-08-08 11:34:00','price'=>5.50,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>3,'hall_id'=>8,'start_time'=>'2026-08-08 14:00:00','end_time'=>'2026-08-08 17:00:00','price'=>7.00,'created_at'=>now(),'updated_at'=>now()],
    ['movie_id'=>5,'hall_id'=>9,'start_time'=>'2026-08-08 19:00:00','end_time'=>'2026-08-08 21:56:00','price'=>6.50,'created_at'=>now(),'updated_at'=>now()],
]

    ]);
}
}
