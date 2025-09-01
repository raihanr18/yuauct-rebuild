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
        // Create Admin
        User::create([
            'name' => 'Admin YuAUCT',
            'username' => 'admin',
            'email' => 'admin@yuauct.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567890',
            'role' => 'admin',
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff Lelang',
            'username' => 'staff',
            'email' => 'staff@yuauct.com',
            'password' => Hash::make('password'),
            'phone_number' => '081234567891',
            'role' => 'staff',
        ]);

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
