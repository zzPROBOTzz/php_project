-- Create the database
CREATE DATABASE IF NOT EXISTS ad_system;
USE ad_system;

-- Create the users table first (since it will be referenced by advertisements)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create the advertisements table
CREATE TABLE IF NOT EXISTS advertisements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add some sample data (commented out until you have created a user)
/*
INSERT INTO advertisements (title, description, price, user_id) VALUES
('iPhone 13 Pro for Sale', 'Brand new iPhone 13 Pro, 256GB storage, Pacific Blue color. Comes with original box and accessories.', 999.99, 1),
('2 Bedroom Apartment for Rent', 'Spacious 2 bedroom apartment in downtown area. Newly renovated, includes parking and utilities.', 1500.00, 1),
('Professional Web Development Services', 'Expert web development services. Specializing in PHP, MySQL, and modern frontend frameworks.', 75.00, 1);
*/ 
