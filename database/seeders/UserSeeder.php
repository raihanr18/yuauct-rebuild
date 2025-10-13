<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin (skip if already exists)
        User::firstOrCreate(
            ['email' => 'admin@yuauct.com'],
            [
                'name' => 'Admin YuAUCT',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'phone_number' => '081234567890',
                'role' => 'admin',
            ]
        );

        // Create Staff (skip if already exists)
        User::firstOrCreate(
            ['email' => 'staff@yuauct.com'],
            [
                'name' => 'Staff Lelang',
                'username' => 'staff',
                'password' => Hash::make('password'),
                'phone_number' => '081234567891',
                'role' => 'staff',
            ]
        );

        // Create Regular User
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567892',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567893',
            'role' => 'user',
        ]);
    }
}
