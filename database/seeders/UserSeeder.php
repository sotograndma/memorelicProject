<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'admin123',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
        ]);

        // Customer Account
        User::create([
            'name' => 'budi',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budibudibudi'),
            'role' => 'customer',
        ]);

        // Customer Account
        User::create([
            'name' => 'azril',
            'email' => 'azril@gmail.com',
            'password' => Hash::make('azrilazrilazril'),
            'role' => 'customer',
        ]);
    }
}
