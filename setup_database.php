<?php
// Database setup script for Inventory Management System
$host = '127.0.0.1';
$port = '3307';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS inventory_system");
    $pdo->exec("USE inventory_system");
    
    // Create categories table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    
    // Create products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            quantity INT NOT NULL DEFAULT 0,
            sku VARCHAR(255) UNIQUE NOT NULL,
            category_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )
    ");
    
    // Insert sample categories
    $pdo->exec("
        INSERT IGNORE INTO categories (name, description) VALUES
        ('Electronics', 'Electronic devices and accessories'),
        ('Clothing', 'Apparel and fashion items'),
        ('Books', 'Books and educational materials'),
        ('Home & Garden', 'Home improvement and garden supplies'),
        ('Sports', 'Sports equipment and accessories')
    ");
    
    // Insert sample products
    $pdo->exec("
        INSERT IGNORE INTO products (name, description, price, quantity, sku, category_id) VALUES
        ('Laptop Computer', 'High-performance laptop for work and gaming', 1299.99, 15, 'LAPTOP-001', 1),
        ('Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 29.99, 50, 'MOUSE-001', 1),
        ('Cotton T-Shirt', 'Comfortable cotton t-shirt in various sizes', 19.99, 100, 'TSHIRT-001', 2),
        ('Programming Book', 'Complete guide to web development', 49.99, 25, 'BOOK-001', 3),
        ('Garden Hose', '50ft expandable garden hose with spray nozzle', 39.99, 30, 'GARDEN-001', 4),
        ('Basketball', 'Official size basketball for indoor and outdoor use', 24.99, 20, 'SPORT-001', 5)
    ");
    
    echo "✅ Database setup completed successfully!\n";
    echo "✅ Database 'inventory_system' created\n";
    echo "✅ Tables 'categories' and 'products' created\n";
    echo "✅ Sample data inserted\n";
    echo "\nYou can now access the application at: http://localhost/TH/\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nPlease make sure:\n";
    echo "1. XAMPP is running\n";
    echo "2. MySQL is running on port 3307\n";
    echo "3. You can access phpMyAdmin\n";
}
?>
