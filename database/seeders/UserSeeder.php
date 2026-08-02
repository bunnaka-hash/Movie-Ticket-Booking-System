<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'phone' => '012345678',
            ],
            [
                'name' => 'Cinema Staff',
                'email' => 'staff@gmail.com',
                'role' => 'staff',
                'phone' => '012345679',
            ],
            [
                'name' => 'John Customer',
                'email' => 'customer@gmail.com',
                'role' => 'customer',
                'phone' => '012345680',
            ],
            [
                'name' => 'Sokha Customer',
                'email' => 'sokha@gmail.com',
                'role' => 'customer',
                'phone' => '012345681',
            ],
            [
                'name' => 'Dara Customer',
                'email' => 'dara@gmail.com',
                'role' => 'customer',
                'phone' => '012345682',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user + ['password' => 'password']
            );
        }
    }
}
