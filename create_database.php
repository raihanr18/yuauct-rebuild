<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS yuauct_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database 'yuauct_laravel' created successfully!\n";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage() . "\n";
}
