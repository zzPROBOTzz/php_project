<?php
require_once __DIR__ . '/config/database.php';

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    // Create database
    $conn->query("DROP DATABASE IF EXISTS " . DB_NAME);
    $conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $conn->select_db(DB_NAME);
    
    // Create users table
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    // Create advertisements table
    $conn->query("CREATE TABLE IF NOT EXISTS advertisements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255),
        user_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "Database setup completed successfully!\n";
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
} 