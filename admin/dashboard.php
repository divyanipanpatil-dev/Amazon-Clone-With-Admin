<?php
session_start();

// Check if admin is NOT logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect directly back to the login page
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Fetch dynamic counts from your Amazon database
$product_count = 0;
$p_res = $conn->query("SELECT COUNT(*) as total FROM products");
if ($p_res) { $product_count = $p_res->fetch_assoc()['total']; }

$card_count = 0;
$c_res = $conn->query("SELECT COUNT(*) as total FROM categories");
if ($c_res) { $card_count = $c_res->fetch_assoc()['total']; }

// Optional placeholders for Users and Orders
$user_count = 0;
$order_count = 0;
$total_sales = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { display: flex; background-color: #e5e5dd; min-height: 100vh; }

        /* Left Dark Sidebar */
        .sidebar { width: 220px; background-color: #212529; color: #ffffff; padding: 25px 0; display: flex; flex-direction: column; }
        .sidebar h2 { padding: 0 20px 30px 20px; font-size: 1.3rem; font-weight: 600; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 20px; color: #a0a5ad; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: 0.2s; }
        .sidebar-menu li a i { margin-right: 12px; width: 18px; text-align: center; }
        .sidebar-menu li.active a, .sidebar-menu li a:hover { color: #ffffff; background-color: #2c3036; }

        /* Main Workspace */
        .main-content { flex: 1; padding: 40px 50px; }
        .welcome-title { font-size: 1.8rem; color: #111111; margin-bottom: 30px; font-weight: 600; }

        /* Stats Row */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .card { background-color: #ffffff; padding: 30px 20px; border-radius: 2px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h3 { font-size: 0.95rem; color: #333333; font-weight: 600; margin-bottom: 20px; }
        .card .number { font-size: 1.8rem; color: #111111; font-weight: 700; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>MyShop Admin</h2>
        <ul class="sidebar-menu">
            <li class="active"><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Add Product</a></li>
            <li><a href="add_category.php"><i class="fa-solid fa-layer-group"></i> Add Home Card</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-square-minus"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1 class="welcome-title">Welcome, <?php echo isset($_SESSION['admin_user']) ? htmlspecialchars($_SESSION['admin_user']) : 'Admin'; ?> 👋</h1>

        <div class="stats-grid">
            <div class="card">
                <h3>Products</h3>
                <div class="number"><?php echo $product_count; ?></div>
            </div>
            <div class="card">
                <h3>Home Cards</h3>
                <div class="number"><?php echo $card_count; ?></div>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <div class="number"><?php echo $order_count; ?></div>
            </div>
            <div class="card">
                <h3>Sales</h3>
                <div class="number">₹<?php echo number_format($total_sales, 0); ?></div>
            </div>
        </div>
    </div>

</body>
</html>