<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Super Admin
        User::firstOrCreate(
            ['email' => 'admin@yuauct.com'],
            [
                'name' => 'Super Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'phone_number' => '+62812345678',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'admin_notes' => 'Initial super administrator account created via seeder',
            ]
        );

        // Create Staff User
        User::firstOrCreate(
            ['email' => 'staff@yuauct.com'],
            [
                'name' => 'Staff Manager',
                'username' => 'staff',
                'password' => Hash::make('staff123'),
                'phone_number' => '+62812345679',
                'role' => 'staff',
                'status' => 'active',
                'email_verified_at' => now(),
                'admin_notes' => 'Initial staff account created via seeder',
            ]
        );

        // Create Demo Regular User
        User::firstOrCreate(
            ['email' => 'user@yuauct.com'],
            [
                'name' => 'Demo User',
                'username' => 'user',
                'password' => Hash::make('user123'),
                'phone_number' => '+62812345680',
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
                'admin_notes' => 'Demo user account created via seeder',
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->line('');
        $this->command->line('=== LOGIN CREDENTIALS ===');
        $this->command->line('Admin: admin@yuauct.com / admin123');
        $this->command->line('Staff: staff@yuauct.com / staff123');
        $this->command->line('User:  user@yuauct.com  / user123');
        $this->command->line('========================');
    }
}
