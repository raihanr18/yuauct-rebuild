<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {password} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name');

        // Delete existing user with same email
        User::where('email', $email)->delete();

        // Create new admin user
        $user = User::create([
            'name' => $name,
            'username' => explode('@', $email)[0],
            'email' => $email,
            'password' => Hash::make($password),
            'phone_number' => '+62000000000',
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
            'admin_notes' => 'Created via artisan command',
        ]);

        $this->info("Admin user created successfully!");
        $this->line("Email: {$user->email}");
        $this->line("Password: {$password}");
        $this->line("Role: {$user->role}");

        // Test password
        if (Hash::check($password, $user->password)) {
            $this->info("✓ Password verification: PASSED");
        } else {
            $this->error("✗ Password verification: FAILED");
        }

        return 0;
    }
}
