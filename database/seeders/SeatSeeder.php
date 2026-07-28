<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    foreach ([1,2,3] as $hall){

        foreach(range('A','F') as $row){

            for($i=1;$i<=10;$i++){

                \App\Models\Seat::create([

                    'hall_id'=>$hall,
                    'seat_number'=>$row.$i,
                    'row_name'=>$row,
                    'seat_type'=>'regular'

                ]);

            }

        }

    }
}
}
