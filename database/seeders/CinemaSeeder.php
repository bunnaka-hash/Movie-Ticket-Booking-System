<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Cinema::insert([
    [
                'name'=>'Legend Cinema1',
                'address'=>'Aeon2 Mall',
                'city'=>'Phnom Penh',
                'phone'=>'023111111',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'Legend Cinema2',
                'address'=>'Chip Mong 271 Mall',
                'city'=>'Phnom Penh',
                'phone'=>'023222222',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

            [
                'name'=>'Sabay Cinema',
                'address'=>'Olympia Mall',
                'city'=>'Phnom Penh',
                'phone'=>'023333333',
                'created_at'=>now(),
                'updated_at'=>now()
            ],

    ]);
}
}
