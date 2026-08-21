<?php 
include 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon Clone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="nav-en border">
                <i class="fa-solid fa-globe"></i> English
            </div>

            <div class="nav-signin border">
                <p><span>Hello, sign in</span></p>
                <p class="nav-second">Account & Lists</p>
            </div>

            <div class="nav-return border">
                <p><span>Returns</span></p>
                <p class="nav-second">& Orders</p>
            </div>

            <div class="nav-cart border">
                <i class="fa-solid fa-cart-shopping"></i>
                <p>Cart</p>
            </div>
        </div>

        <div class="panel">
            <div class="panel-all">
                <i class="fa-solid fa-bars"></i>
            </div>
            <div class="panel-ops">
                <a href="">All </a>
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
                <a href="">Mobiles</a>
                <a href="">Electronics</a>
                <a href="">Computers</a>
                <a href="">Amazon Pay</a>
                <a href="">Sell</a>
            </div>
        </div>
    </header>

    <div class="hero">
        <div class="hero-message">
            <p>You are on amazon.com. You can also shop on Amazon India for millions of products with fast local delivery. <a>Click here to go to amazon.in</a></p>
        </div>
    </div>

    <!-- DYNAMIC SHOP SECTION -->
    <div class="shop-section">
        <?php
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if image exists in uploads, else use local folder
                $imgPath = file_exists("uploads/" . $row['image_url']) ? "uploads/" . $row['image_url'] : $row['image_url'];
                ?>
                <div class="box">
                    <div class="box-content">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <div class="box-img" style="background-image: url('<?php echo $imgPath; ?>');"></div>
                        <p><a href="category.php?cat=<?php echo urlencode($row['category_slug']); ?>" style="color: #007185; text-decoration: none; font-weight: bold;">Shop Now</a></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='padding: 20px;'>No Cards Found. Add categories from Admin Panel!</p>";
        }
        ?>
    </div>
    

    <footer>
        <div class="foot-panel1">Back To Top</div>
        <div class="foot-panel2">
            <ul>
                <p>Get to Know Us</p>
                <a>Careers</a>
                <a>Blog</a>
                <a>About Amazon</a>
            </ul>
            <ul>
                <p>Connect with Us</p>
                <a>Facebook</a>
                <a>Instagram</a>
            </ul>
            <ul>
                <p>Make Money with us</p>
                <a>Sell on Amazon</a>
                <a>Become an Affiliate</a>
            </ul>
            <ul>
                <p>Let Us Help You</p>
                <a>Your Account</a>
                <a>Returns Center</a>
                <a>Help</a>
            </ul>
        </div>

        <div class="foot-panel3">
            <div class="logo"></div>
            <button class="btn"><i class="fa-solid fa-globe"></i> English</button>
            <button class="btn"><i class="fa-regular fa-flag"></i> India</button>
        </div>

        <div class="foot-panel4">
            <div class="pages">
                <a>Conditions of Use</a>
                <a>Privacy Notice</a>
            </div>
            <div class="copy">&copy; 1996-2026, Amazon.com, Inc. or its affiliates</div>
        </div>
    </footer>
</body>
</html>