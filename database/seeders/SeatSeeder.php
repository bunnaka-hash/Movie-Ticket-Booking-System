<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {

        for($hall=1;$hall<=9;$hall++){


            foreach(range('A','F') as $row){


                for($i=1;$i<=10;$i++){


                    Seat::create([

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