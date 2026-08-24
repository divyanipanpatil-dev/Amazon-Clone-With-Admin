<?php 
// Database Connection File
include 'config/db.php'; 

// URL मधून Category Slug घेणे (उदा. category.php?cat=footwear)
$cat_slug = $_GET['cat'] ?? '';

// Category चे नाव शोधण्यासाठी Query
$cat_query = $conn->prepare("SELECT title FROM categories WHERE category_slug = ?");
$cat_query->bind_param("s", $cat_slug);
$cat_query->execute();
$cat_result = $cat_query->get_result();
$cat_data = $cat_result->fetch_assoc();

// जर नाव सापडले नाही तर बाय-डिफॉल्ट 'Products' नाव दाखवणे
$category_name = $cat_data['title'] ?? 'Products';
?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        <style>
        .category-header {
            background-color: #232f3e;
            height:50px;
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .category-header h1 {
            font-size: 1.5rem;
        }
        .back-link {
            color: #febd68;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .product-grid { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 23px; 
            padding: 30px; 
            background: #eaeded; 
            min-height: 80vh; 
        }
        .product-card { 
            background: white; 
            padding: 15px; 
            border-radius: 4px; 
            width: 270px; 
            text-align: center; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.12); 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card img { 
            width: 100%; 
            height: 250px; 
            object-fit: contain; 
            margin-bottom: 10px;
        }
        .product-title { 
            font-size: 0.95rem; 
            margin: 10px 0; 
            color: #0f1111; 
            font-weight: 500;
        }
        .product-price { 
            color: #B12704; 
            font-size: 1.2rem; 
            font-weight: bold; 
            margin-bottom: 10px; 
        }
        .add-btn { 
            background: #ffd814; 
            border: 1px solid #fcd200; 
            padding: 8px 15px; 
            border-radius: 20px; 
            cursor: pointer; 
            font-size: 0.85rem; 
            font-weight: bold;
        }
        .add-btn:hover {
            background: #f7ca00;
        }
        .no-products {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            width: 100%;
}
    </style>
</head>
    <header>
        <div class="navbar">
            <div class="navlogo border">
                <div class="logo"></div>
            </div>

            <div class="navaddress border">
                <p class="add1">Deliver to</p>
                <div class="add-icon">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="add2">India</p>
                </div>
            </div>

            <div class="nav-search">
                <select class="search-select">
                    <option>All</option>
                </select>
                <input type="text" placeholder="Search Amazon" class="search-input">
                <div class="search-icon">
                    <i class="fa-solid fa-magnifying-glass-minus"></i>
                </div>
            </div>

            <div class="nav-en border">
                <i class="fa-solid fa-globe"></i>
                English
            </div>


            <div class="nav-signin border" onclick="location.href='sign_in.html'">
                <p><span>Hello, sign in</span>
                <p class="nav-second">Account & Lists</p>
            </div>

            <div class="nav-return border" onclick="location=''">
                <p><span>Returns</span>
                <p class="nav-second">& Orders</p>
            </div>

            <div class="nav-cart border" onclick="location=''">
                <i class="fa-solid fa-cart-shopping"></i>
                <p>Cart</p>
            </div>
        </div>

        <div class="panel">
            <div class="panel-all">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div class="panel-ops ">
                <a href="">All</a>
                <a href="">Today's Deals</a>
                <a href="">Customer Service</a>
                <a href="">Registry</a>
                <a href="">Gift Cards</a>
                <a href="">MX Player</a>
                <a href="">Prime</a>
                <a href="">Home & Kitchen</a>
                <a href="">Bestsellers</a>
                <a href="">New Releases</a>
                <a href="">Fashion</a>
                <a href="">Moblies</a>
                <a href="">Electronics</a>
                <a href="">Computers</a>
                <a href="">Amazon Pay</a>
                <a href="">Sell</a>
            </div>
        </div>
</header>
<body>
    <!-- Sub Header Bar -->
    <div class="category-header">
        <h1>Category: <?php echo htmlspecialchars($category_name); ?></h1>
    </div>

    <!-- Dynamic Products Grid -->
    <div class="product-grid">
        <?php
        // Selected Category मधील Products Fetch करणे
        $stmt = $conn->prepare("SELECT * FROM products WHERE category_slug = ?");
        $stmt->bind_param("s", $cat_slug);
        $stmt->execute();
        $products = $stmt->get_result();

        if ($products && $products->num_rows > 0) {
            while ($p = $products->fetch_assoc()) {
                // Image path check
                $img = !empty($p['image_url']) ? "uploads/" . $p['image_url'] : 'https://via.placeholder.com/200';
                ?>
                <div class="product-card">
                    <div>
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="product">
                        <div class="product-title"><?php echo htmlspecialchars($p['title']); ?></div>
                    </div>
                    <div>
                        <div class="product-price">₹<?php echo number_format($p['price'], 2); ?></div>
                        <button class="add-btn">Add to Cart</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "
            <div class='no-products'>
                <h2>No products found in this category!</h2>
                <p style='margin-top: 10px; color: #555;'>Admin Panel मधून या Category (<b>".htmlspecialchars($cat_slug)."</b>) मध्ये नवीन Products जोडण्यास सांगा.</p>
            </div>";
        }
        ?>
    </div>

</body>
</html>