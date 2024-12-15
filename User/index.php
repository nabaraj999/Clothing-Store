<?php
session_start(); // Start the session at the beginning

$servername = "localhost"; // Change if necessary
$username = "root"; // Change this
$password = ""; // Change this
$dbname = "cs"; // Change this

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve gender from request (defaults to "Men" if not provided)
$gender = isset($_GET['gender']) ? $_GET['gender'] : 'Men';

// Fetch products based on the selected gender
$sql = "SELECT * FROM products WHERE gender = ? OR gender = 'Both'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $gender);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Check if the user is logged in and retrieve username from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Loft - Online Clothing Store</title>
    <!-- Load Font Awesome for Icons -->
     <!-- Load Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Load CSS for Slick Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="product_display.css">
</head>
<body>
    
<!-- Header Section -->
<header class="header">
    <!-- Left Logo Section -->
    <div class="logo">Fashion Loft</div>

    <!-- Center Navigation Bar -->
    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="product_display.php">Shop</a>
        <a href="About.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="help.php">Help</a>
    </nav>

    <!-- Right-Side Search, Cart, Profile -->
    <div class="header-right">
        <input type="text" placeholder="Search">
        <div class="cart-container">
            <i class="fas fa-shopping-cart icon" onclick="redirectToCart()"></i>
            <span class="cart-count">
                <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
            </span>
        </div>
        <div class="user-icon-container">
    <i class="fas fa-user icon" id="user-icon"></i>
    <div class="user-dropdown">
        <span id="username"><?php echo htmlspecialchars($username); ?></span> <!-- Display the username -->
        <a href="logout.php" id="logout-link" class="logout-button">Logout</a> <!-- Styled logout button -->
    </div>
</div>

    </div>
</header>

<div class="slider-container">
    <div class="slide" style="background-image: url('../images/slide-01.jpg');">
        <div class="slide-content">
            <p>Women & Men Collection 2024</p>
            <h2>NEW SEASON</h2>
            <a href="#" class="shop-btn">SHOP NOW</a>
        </div>
    </div>
    
    <div class="container">
        <div class="card women">
            <h2>Women</h2>
            <p>Spring 2018</p>
            <button onclick="alert('Shop Women Collection')">SHOP NOW</button>
        </div>
        <div class="card men">
            <h2>Men</h2>
            <p>Spring 2018</p>
            <button onclick="alert('Shop Men Collection')">SHOP NOW</button>
        </div>
        <div class="card accessories">
            <h2>Accessories</h2>
            <p>New Trend</p>
            <button onclick="alert('Shop Accessories')">SHOP NOW</button>
        </div>
    </div>


    <div class="filter-buttons">
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Men">
        <button type="submit" class="<?= $gender === 'Men' ? 'active' : '' ?>">Men</button>
    </form>
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Women">
        <button type="submit" class="<?= $gender === 'Women' ? 'active' : '' ?>">Women</button>
    </form>
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Both">
        <button type="submit" class="<?= $gender === 'Both' ? 'active' : '' ?>">Both</button>
    </form>
</div>

<div class="product-container">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo !empty($product['front_photo']) ? '../uploads/' . $product['front_photo'] : 'placeholder.png'; ?>" alt="<?php echo $product['product_name']; ?>">
                </div>
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p>NPR <?php echo number_format($product['price'], 2); ?></p>
                <form action="purchase.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="purchase-button">Purchase</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available for this category.</p>
    <?php endif; ?>
</div>

<script>
    // Dynamically highlight the selected button
    document.querySelectorAll('.filter-buttons button').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.filter-buttons button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

<!-- Modal for full-size image -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="modalImage" src="" alt="Full Size Image">
    </div>
</div>



<link rel = "stylesheet" href="index.css">
<footer class="footer">
        <div class="footer-container">
            <!-- Categories Section -->
            <div class="footer-section">
                <h3 class="footer-title">Categories</h3>
                <ul>
                    <li><a href="#">Women</a></li>
                    <li><a href="#">Men</a></li>
                    <li><a href="#">Shoes</a></li>
                    <li><a href="#">Watches</a></li>
                </ul>
            </div>
            <!-- Help Section -->
            <div class="footer-section">
                <h3 class="footer-title">Help</h3>
                <ul>
                    <li><a href="#">Track Order</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <!-- Get in Touch Section -->
            <div class="footer-section">
                <h3 class="footer-title">Get in Touch</h3>
                <p>Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
            <!-- Newsletter Section -->
            <div class="footer-section">
                <h3 class="footer-title">Newsletter</h3>
                <form>
                    <input type="email" placeholder="email@example.com" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <!-- Bottom Section -->
        <div class="footer-bottom">
            <div class="payment-icons">
                <img src="../images/icon-pay-01.png" alt="PayPal">
                <img src="../images/icon-pay-02.png" alt="Visa">
                <img src="../images/icon-pay-03.png" alt="MasterCard">
                <img src="../images/icon-pay-04.png" alt="Discover">
            </div>
            <p>Copyright ©2024 All rights reserved | Made with ❤️ by Colorlib & distributed by ThemeWagon</p>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>





<!-- Optional JavaScript for Interactivity -->
<script>
    // Add interactivity if needed, for example for the search bar or cart icon
    const searchInput = document.querySelector('.header-right input[type="text"]');
    searchInput.addEventListener('focus', () => {
        searchInput.style.borderColor = '#f39c12';
    });

    $(document).ready(function(){
    $('.slider-container').slick({
        autoplay: true,
        autoplaySpeed: 3000,  // Change slide every 3 seconds
        arrows: true,         // Show navigation arrows
        dots: true,           // Show dots for slide indicators
        infinite: true,       // Infinite looping
        slidesToShow: 1,      // Show one slide at a time
        slidesToScroll: 1,    // Scroll one slide at a time
        speed: 800,           // Speed of the sliding transition
        cssEase: 'linear'     // Smooth sliding effect
    });
});
let cartCount = 0;

    document.getElementById('addToCartButton').addEventListener('click', function() {
        // Increment cart count
        cartCount += 1;
        document.getElementById('cart-count').textContent = cartCount;

        // Optionally store cart data (e.g., in local storage or session)
        // localStorage.setItem('cart', JSON.stringify({ item_id: <?php echo $product_id; ?> }));

        // Confirmation of addition (optional)
        alert('Item added to cart!');
    });

    function redirectToCart() {
        // Redirect to the cart/billing page
        window.location.href = 'billing_page.php';
    }

    document.querySelectorAll('.social-icons a').forEach(icon => {
    icon.addEventListener('mouseover', () => {
        icon.style.transform = 'scale(1.2)';
    });
    icon.addEventListener('mouseleave', () => {
        icon.style.transform = 'scale(1)';
    });
});

</script>

</body>
</html>
