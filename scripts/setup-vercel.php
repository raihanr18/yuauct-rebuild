<?php

// Script untuk setup database di Vercel
// Jalankan ini setelah deployment pertama

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set environment ke production
$app->make('config')->set('app.env', 'production');

// Generate APP_KEY jika belum ada
if (empty(env('APP_KEY'))) {
    $key = 'base64:' . base64_encode(random_bytes(32));
    echo "Generated APP_KEY: " . $key . "\n";
    echo "Please set this in your Vercel environment variables\n";
}

// Run migrations
echo "Running migrations...\n";
Artisan::call('migrate', ['--force' => true]);

// Run seeders
echo "Running seeders...\n";
Artisan::call('db:seed', ['--force' => true]);

echo "Setup completed!\n";
