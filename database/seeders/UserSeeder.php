<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin Sky Yoga',
            'email' => 'admin@skyyoga.com',
            'phone_number' => '081111111111',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Akun Member 1
        User::create([
            'name' => 'Budi Member',
            'email' => 'budi@gmail.com',
            'phone_number' => '082222222222',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        // Akun Member 2
        User::create([
            'name' => 'Siti Member',
            'email' => 'siti@gmail.com',
            'phone_number' => '083333333333',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);
    }
}