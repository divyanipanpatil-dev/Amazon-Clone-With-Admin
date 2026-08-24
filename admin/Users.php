<?php
include '../config/db.php';

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $u_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM users WHERE id = $u_id");
    header("Location: users.php?msg=User Deleted Successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop Admin - Users</title>
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
        .table-container { background: white; padding: 25px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { color: #111; }
        .btn-add { background: #ffd814; border: 1px solid #fcd200; padding: 8px 16px; color: #111; text-decoration: none; font-weight: bold; border-radius: 4px; font-size: 0.9rem; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; color: #333; }
        
        .role-badge { padding: 4px 8px; border-radius: 3px; font-size: 0.8rem; font-weight: bold; }
        .role-admin { background: #d1ecf1; color: #0c5460; }
        .role-customer { background: #e2e3e5; color: #383d41; }
        .btn-delete { background: #d9534f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 0.85rem; font-weight: bold; }
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
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
        <div class="table-container">
            <div class="header-flex">
                <h2>Manage Users</h2>
                <a href="add_user.php" class="btn-add"><i class="fa-solid fa-user-plus"></i> Add User</a>
            </div>

            <?php if (isset($_GET['msg'])) echo "<div class='alert'>".$_GET['msg']."</div>"; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM users ORDER BY id DESC");
                    if ($users && $users->num_rows > 0) {
                        while ($u = $users->fetch_assoc()) {
                            $badge_class = ($u['role'] === 'Admin') ? 'role-admin' : 'role-customer';
                            ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><?php echo htmlspecialchars($u['name']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><span class="role-badge <?php echo $badge_class; ?>"><?php echo $u['role']; ?></span></td>
                                <td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                                <td>
                                    <a href="users.php?delete_id=<?php echo $u['id']; ?>" class="btn-delete" onclick="return confirm('Delete this user?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>