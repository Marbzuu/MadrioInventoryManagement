<?php
// Simple Inventory Management System
session_start();

// Database configuration
$host = '127.0.0.1';
$port = '3307';
$dbname = 'inventory_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_category':
                $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
                $stmt->execute([$_POST['name'], $_POST['description']]);
                $_SESSION['message'] = 'Category created successfully!';
                break;
                
            case 'update_category':
                $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
                $stmt->execute([$_POST['name'], $_POST['description'], $_POST['id']]);
                $_SESSION['message'] = 'Category updated successfully!';
                break;
                
            case 'create_product':
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity, sku, category_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['quantity'], $_POST['sku'], $_POST['category_id']]);
                $_SESSION['message'] = 'Product created successfully!';
                break;
                
            case 'update_product':
                $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, sku = ?, category_id = ? WHERE id = ?");
                $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['quantity'], $_POST['sku'], $_POST['category_id'], $_POST['id']]);
                $_SESSION['message'] = 'Product updated successfully!';
                break;
                
            case 'delete_category':
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $_SESSION['message'] = 'Category deleted successfully!';
                break;
                
            case 'delete_product':
                $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $_SESSION['message'] = 'Product deleted successfully!';
                break;
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Get current page
$page = $_GET['page'] ?? 'home';

// Get categories
$categories = $pdo->query("SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id")->fetchAll();

// Get products
$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id")->fetchAll();

// Get specific category or product for view/edit
$category = null;
$product = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if ($page === 'category' || $page === 'edit_category') {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch();
    } elseif ($page === 'product' || $page === 'edit_product') {
        $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 25px rgba(0,0,0,0.1);
            --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: var(--light-bg);
            min-height: 100vh;
        }
        
        .navbar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 5px;
            padding: 8px 16px !important;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        .btn-success {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
        }
        
        .btn-info {
            background: var(--warning-gradient);
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 233, 123, 0.6);
        }
        
        .btn-danger {
            background: var(--danger-gradient);
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(250, 112, 154, 0.6);
        }
        
        .btn-outline-primary {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box, var(--primary-gradient) border-box;
            color: #667eea;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-danger {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box, var(--danger-gradient) border-box;
            color: #fa709a;
        }
        
        .btn-outline-danger:hover {
            background: var(--danger-gradient);
            color: white;
            transform: translateY(-2px);
        }
        
        .jumbotron {
            background: var(--primary-gradient);
            color: white;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .jumbotron::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .jumbotron .container {
            position: relative;
            z-index: 1;
        }
        
        .badge {
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 600;
        }
        
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }
        
        .table thead th {
            background: var(--dark-gradient);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.01);
        }
        
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            font-weight: 500;
        }
        
        .alert-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .alert-danger {
            background: var(--danger-gradient);
            color: white;
        }
        
        .text-center.py-5 {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            margin: 20px 0;
        }
        
        .fa-3x {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .fa-2x {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .display-4 {
            font-weight: 700;
            text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .lead {
            font-weight: 400;
            opacity: 0.9;
        }
        
        .container {
            max-width: 1200px;
        }
        
        .row {
            margin: 0 -10px;
        }
        
        .col-md-6, .col-lg-4, .col-12 {
            padding: 0 10px;
            margin-bottom: 20px;
        }
        
        .card-body h5 {
            font-weight: 600;
            color: #2d3748;
        }
        
        .card-text {
            color: #718096;
            line-height: 1.6;
        }
        
        .text-muted {
            color: #a0aec0 !important;
        }
        
        .btn-group .btn {
            margin: 0 2px;
        }
        
        .input-group-text {
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-weight: 600;
        }
        
        code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="?page=home">
                <i class="fas fa-warehouse me-2"></i>Inventory System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="?page=categories">
                        <i class="fas fa-tags me-1"></i>Categories
                    </a>
                    <a class="nav-link" href="?page=products">
                        <i class="fas fa-box me-1"></i>Products
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php
        switch ($page) {
            case 'categories':
                include 'pages/categories.php';
                break;
            case 'category':
                include 'pages/category_view.php';
                break;
            case 'edit_category':
                include 'pages/category_edit.php';
                break;
            case 'products':
                include 'pages/products.php';
                break;
            case 'product':
                include 'pages/product_view.php';
                break;
            case 'edit_product':
                include 'pages/product_edit.php';
                break;
            default:
                include 'pages/home.php';
                break;
        }
        ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
