<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users for CRUD testing
        $testUsers = [
            [
                'name' => 'Test User 1',
                'username' => 'testuser1',
                'email' => 'test1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'status' => 'active',
                'phone_number' => '081234567890',
                'email_verified_at' => now(),
                'admin_notes' => 'Test user created for CRUD testing'
            ],
            [
                'name' => 'Test Staff',
                'username' => 'teststaff',
                'email' => 'staff@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'status' => 'active',
                'phone_number' => '081234567891',
                'email_verified_at' => now(),
                'admin_notes' => 'Test staff member for testing'
            ],
            [
                'name' => 'Suspended User',
                'username' => 'suspendeduser',
                'email' => 'suspended@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'status' => 'suspended',
                'phone_number' => '081234567892',
                'email_verified_at' => now(),
                'admin_notes' => 'User suspended for testing purposes'
            ]
        ];

        foreach ($testUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Test users created successfully for CRUD testing!');
    }
}
