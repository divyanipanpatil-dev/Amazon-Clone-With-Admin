<?php
include '../config/db.php';

$msg = "";

if (isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $role);
    
    if ($stmt->execute()) {
        header("Location: users.php?msg=User Added Successfully");
        exit();
    } else {
        $msg = "Error: Email might already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop Admin - Add User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { display: flex; background-color: #e5e5dd; min-height: 100vh; }
        .sidebar { width: 220px; background-color: #212529; color: #ffffff; padding: 25px 0; }
        .sidebar h2 { padding: 0 20px 30px 20px; font-size: 1.3rem; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 20px; color: #a0a5ad; text-decoration: none; font-size: 0.95rem; }
        .sidebar-menu li a i { margin-right: 12px; width: 18px; text-align: center; }
        .sidebar-menu li.active a, .sidebar-menu li a:hover { color: #ffffff; background-color: #2c3036; }
        
        .main-content { flex: 1; padding: 40px; }
        .form-card { background: white; max-width: 500px; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        h2 { margin-bottom: 20px; color: #111; }
        label { font-weight: bold; font-size: 0.9rem; display: block; margin-top: 15px; color: #333; }
        input, select, button { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #ffd814; border: 1px solid #fcd200; font-weight: bold; cursor: pointer; margin-top: 20px; }
        button:hover { background: #f7ca00; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>MyShop Admin</h2>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Add Product</a></li>
            <li><a href="add_category.php"><i class="fa-solid fa-layer-group"></i> Add Home Card</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li class="active"><a href="users.php"><i class="fa-solid fa-users"></i> Users</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-square-minus"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-card">
            <h2>Add User</h2>

            <?php if ($msg) echo "<div class='alert-error'>$msg</div>"; ?>

            <form method="POST">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required>

                <label>Email Address</label>
                <input type="email" name="email" placeholder="john@example.com" required>

                <label>Role</label>
                <select name="role">
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                </select>

                <button type="submit" name="add_user">Create User</button>
            </form>
        </div>
    </div>

</body>
</html>