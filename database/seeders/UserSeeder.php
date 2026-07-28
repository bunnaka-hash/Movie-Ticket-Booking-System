<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\User::insert([

        [
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '012345678',
            'created_at' => now(),
            'updated_at' => now(),
        ],

        [
            'name' => 'Cinema Staff',
            'email' => 'staff@gmial.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'phone' => '012345679',
            'created_at' => now(),
            'updated_at' => now(),
        ],

        [
            'name' => 'John Customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '012345680',
            'created_at' => now(),
            'updated_at' => now(),
        ]

    ]);
}
}
