<?php
include '../config/db.php';

$msg = "";

if (isset($_POST['add_product'])) {
    $cat_slug = $_POST['category_slug'];
    $p_title = trim($_POST['p_title']);
    $price = $_POST['price'];
    
    $p_image = $_FILES['p_image']['name'];
    $targetDir = "../uploads/" . basename($p_image);

    if (move_uploaded_file($_FILES['p_image']['tmp_name'], $targetDir)) {
        $stmt = $conn->prepare("INSERT INTO products (category_slug, title, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $cat_slug, $p_title, $price, $p_image);
        if ($stmt->execute()) {
            $msg = "Product added successfully!";
        }
    } else {
        $msg = "Failed to upload image. Ensure the 'uploads' folder exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop Admin - Add Product</title>
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
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>MyShop Admin</h2>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fa-solid fa-box"></i> Products</a></li>
            <li class="active"><a href="add_product.php"><i class="fa-solid fa-plus"></i> Add Product</a></li>
            <li><a href="add_category.php"><i class="fa-solid fa-layer-group"></i> Add Home Card</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-square-minus"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-card">
            <h2>Add Product</h2>

            <?php if ($msg) echo "<div class='alert'>$msg</div>"; ?>

            <form method="POST" enctype="multipart/form-data">
                <label>Select Category Card</label>
                <select name="category_slug" required>
                    <option value="">-- Select Category --</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM categories");
                    while ($c = $cats->fetch_assoc()) {
                        echo "<option value='".$c['category_slug']."'>".$c['title']."</option>";
                    }
                    ?>
                </select>

                <label>Product Title</label>
                <input type="text" name="p_title" placeholder="Product Name" required>

                <label>Price (₹)</label>
                <input type="number" step="0.01" name="price" placeholder="999.00" required>

                <label>Product Image</label>
                <input type="file" name="p_image" required>

                <button type="submit" name="add_product">Add Product</button>
            </form>
        </div>
    </div>

</body>
</html>