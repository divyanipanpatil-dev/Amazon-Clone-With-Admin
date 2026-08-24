<?php
include '../config/db.php';

// Handle Product Delete Logic
if (isset($_GET['delete_id'])) {
    $p_id = intval($_GET['delete_id']);
    
    // Remove image file from server uploads folder
    $img_res = $conn->query("SELECT image_url FROM products WHERE id = $p_id");
    if ($row = $img_res->fetch_assoc()) {
        $file_path = "../uploads/" . $row['image_url'];
        if (!empty($row['image_url']) && file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $conn->query("DELETE FROM products WHERE id = $p_id");
    header("Location: products.php?msg=Product Deleted Successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop Admin - Products</title>
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
        h2 { margin-bottom: 20px; color: #111; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; vertical-align: middle; }
        th { background: #f8f9fa; color: #333; }
        .img-thumb { width: 50px; height: 50px; object-fit: contain; }
        .btn-edit { background: #0275d8; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 0.85rem; font-weight: bold; }
        .btn-delete { background: #d9534f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 0.85rem; font-weight: bold; }
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>MyShop Admin</h2>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li class="active"><a href="products.php"><i class="fa-solid fa-box"></i> Products</a></li>
            <li><a href="add_product.php"><i class="fa-solid fa-plus"></i> Add Product</a></li>
            <li><a href="add_category.php"><i class="fa-solid fa-layer-group"></i> Add Home Card</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-square-minus"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="table-container">
            <h2>Manage All Products</h2>

            <?php if (isset($_GET['msg'])) echo "<div class='alert'>".$_GET['msg']."</div>"; ?>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category Slug</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $all_prods = $conn->query("SELECT * FROM products ORDER BY id DESC");
                    if ($all_prods && $all_prods->num_rows > 0) {
                        while ($p = $all_prods->fetch_assoc()) {
                            $img = !empty($p['image_url']) ? "../uploads/" . $p['image_url'] : 'https://via.placeholder.com/50';
                            ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($img); ?>" class="img-thumb"></td>
                                <td><?php echo htmlspecialchars($p['title']); ?></td>
                                <td><?php echo htmlspecialchars($p['category_slug']); ?></td>
                                <td>₹<?php echo number_format($p['price'], 2); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="products.php?delete_id=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>