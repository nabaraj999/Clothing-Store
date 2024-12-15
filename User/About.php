<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="About.css">
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

    <!-- Our Story Section -->
    <section class="about-section">
        <div class="text-container">
            <h2>Our Story</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat consequat enim, non auctor massa ultrices non. 
                Morbi sed odio massa. Quisque at vehicula tellus, sed tincidunt augue. 
                Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                Maecenas varius egestas diam, eu sodales metus scelerisque congue.
            </p>
            <p>
                Nullam eu erat bibendum, tempus ipsum eget, dictum enim. Donec non neque ut enim dapibus tincidunt vitae nec augue.
                Suspendisse potenti. Proin ut est diam. Donec condimentum euismod tortor, eget facilisis diam faucibus et. Morbi a tempor elit.
            </p>
            <p>
                Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879.
            </p>
        </div>
        <div class="image-container">
            <img src="../images/about-01.jpg" alt="Our Story Image">
        </div>
    </section>

    <!-- Our Goal Section -->
    <section class="about-section reverse">
        <div class="image-container">
            <img src="../images/about-02.jpg" alt="Our Goal Image">
        </div>
        <div class="text-container">
            <h2>Our Goal</h2>
            <p>
                Donec gravida lorem elit, quis condimentum ex semper sit amet. Fusce eget ligula magna. 
                Aliquam imperdiet sodales. Ut fringilla turpis in vehicula vehicula.
                Pellentesque congue ac orci ut gravida. Aliquam erat volutpat. Donec iaculis lectus a arcu facilisis, eu sodales lectus sagittis.
            </p>
            <p>
                Etiam pellentesque aliquam rutrum. Neque justo eleifend elit, vel tincidunt erat arcu ut sem.
                Sed rutrum, turpis ut commodo efficitur, quam velit convallis ipsum, et maximus enim ligula ac ligula.
            </p>
        </div>
    </section>

    
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
    function addToCart(button) {
    // Find the product ID from the closest cart form
    var productId = button.parentElement.querySelector('.product-id').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_cart.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        try {
            var response = JSON.parse(xhr.responseText);
            
            if (xhr.status === 200 && response.status === 'success') {
                // Update cart count
                document.querySelector(".cart-count").textContent = response.cartCount;
                
                // Show a temporary "added to cart" message
                button.textContent = "Added!";
                button.classList.add("added");
                setTimeout(() => {
                    button.textContent = "Add to Cart";
                    button.classList.remove("added");
                }, 1500);
            } else {
                // Handle error cases
                alert(response.message || "Error adding product to cart");
                
                // If unauthorized, redirect to login
                if (xhr.status === 401) {
                    window.location.href = "login.php";
                }
            }
        } catch (e) {
            alert("Error processing server response");
        }
    };

    xhr.onerror = function () {
        alert("An error occurred while connecting to the server.");
    };

    xhr.send("id=" + encodeURIComponent(productId));
}

function redirectToCart() {
    window.location.href = "cart.php";
}
    
</body>
</html>
