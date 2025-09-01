<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// Test updating last_login_at
$user = User::where('email', 'admin@yuauct.com')->first();

if ($user) {
    echo "Current last_login_at: " . ($user->last_login_at ?? 'null') . "\n";
    
    $user->last_login_at = now();
    $result = $user->save();
    
    echo "Update result: " . ($result ? 'success' : 'failed') . "\n";
    echo "New last_login_at: " . $user->fresh()->last_login_at . "\n";
} else {
    echo "Admin user not found\n";
}
