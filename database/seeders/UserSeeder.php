<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tokobangunan.test'],
            [
                'name' => 'Admin Toko',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@tokobangunan.test'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );
    }
}