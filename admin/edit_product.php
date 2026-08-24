<?php
include '../config/db.php';

$id = intval($_GET['id'] ?? 0);
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if (!$product) {
    header("Location: products.php");
    exit();
}

$msg = "";

if (isset($_POST['update_product'])) {
    $p_title = trim($_POST['p_title']);
    $price = $_POST['price'];
    $cat_slug = $_POST['category_slug'];
    
    // Check if new image uploaded
    if (!empty($_FILES['p_image']['name'])) {
        $p_image = $_FILES['p_image']['name'];
        $targetDir = "../uploads/" . basename($p_image);
        move_uploaded_file($_FILES['p_image']['tmp_name'], $targetDir);
        
        $stmt = $conn->prepare("UPDATE products SET title=?, price=?, category_slug=?, image_url=? WHERE id=?");
        $stmt->bind_param("sdssi", $p_title, $price, $cat_slug, $p_image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET title=?, price=?, category_slug=? WHERE id=?");
        $stmt->bind_param("sdsi", $p_title, $price, $cat_slug, $id);
    }

    if ($stmt->execute()) {
        header("Location: products.php?msg=Product Updated Successfully");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e5e5dd; padding: 40px; }
        .card { background: white; max-width: 500px; margin: auto; padding: 25px; border-radius: 4px; }
        label { font-weight: bold; margin-top: 10px; display: block; }
        input, select, button { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #ffd814; font-weight: bold; border: 1px solid #fcd200; margin-top: 20px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Category</label>
            <select name="category_slug" required>
                <?php
                $cats = $conn->query("SELECT * FROM categories");
                while ($c = $cats->fetch_assoc()) {
                    $selected = ($c['category_slug'] == $product['category_slug']) ? 'selected' : '';
                    echo "<option value='".$c['category_slug']."' $selected>".$c['title']."</option>";
                }
                ?>
            </select>

            <label>Title</label>
            <input type="text" name="p_title" value="<?php echo htmlspecialchars($product['title']); ?>" required>

            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

            <label>Change Image (Optional)</label>
            <input type="file" name="p_image">

            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>

</body>
</html>