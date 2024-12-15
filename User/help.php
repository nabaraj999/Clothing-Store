<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Page</title>
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

    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
        }

        /* Main container */
        .help-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* FAQ section */
        .faq-section {
            margin-bottom: 40px;
        }

        .faq-section h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .faq {
            margin-bottom: 20px;
        }

        .faq h3 {
            font-size: 1.2em;
            color: #4CAF50;
            cursor: pointer;
            transition: color 0.3s;
        }

        .faq h3:hover {
            color: #388E3C;
        }

        .faq p {
            display: none;
            font-size: 1em;
            color: #555;
            margin-top: 5px;
            padding-left: 10px;
        }

        /* Contact section */
        .contact-section {
            margin-bottom: 40px;
        }

        .contact-section h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .contact-info {
            font-size: 1em;
            color: #555;
            line-height: 1.6em;
            text-align: center;
        }

        .contact-info p {
            margin: 5px 0;
        }

        /* Resources section */
        .resources-section h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .resources-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .resource-link {
            display: block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .resource-link:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Help & Support</h1>
</header>

<!-- Main Help Container -->
<div class="help-container">

    <!-- FAQ Section -->
    <div class="faq-section">
        <h2>Frequently Asked Questions</h2>
        
        <div class="faq">
            <h3 onclick="toggleAnswer(this)">1. How do I track my order?</h3>
            <p>Your order can be tracked through the order tracking page. You will need your order number and email address.</p>
        </div>
        
        <div class="faq">
            <h3 onclick="toggleAnswer(this)">2. What is the return policy?</h3>
            <p>We offer a 30-day return policy on all items. Please ensure that items are in their original condition for a full refund.</p>
        </div>
        
        <div class="faq">
            <h3 onclick="toggleAnswer(this)">3. How can I contact customer support?</h3>
            <p>Our customer support team is available via email at support@example.com or by phone at +1 800 123 4567.</p>
        </div>
        
        <div class="faq">
            <h3 onclick="toggleAnswer(this)">4. How do I change my account information?</h3>
            <p>You can update your account information in the "Account Settings" section after logging in.</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="contact-section">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <p>If you need further assistance, please contact us:</p>
            <p><strong>Email:</strong> support@example.com</p>
            <p><strong>Phone:</strong> +1 800 123 4567</p>
            <p><strong>Hours:</strong> Monday - Friday, 9 AM - 5 PM</p>
        </div>
    </div>

    <!-- Resources Section -->
    <div class="resources-section">
        <h2>Helpful Resources</h2>
        <div class="resources-links">
            <a href="guide.html" class="resource-link">User Guide</a>
            <a href="faq.html" class="resource-link">Detailed FAQs</a>
            <a href="tutorial.html" class="resource-link">Video Tutorials</a>
            <a href="terms.html" class="resource-link">Terms of Service</a>
            <a href="privacy.html" class="resource-link">Privacy Policy</a>
        </div>
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



<script>
    // Toggle FAQ answers
    function toggleAnswer(faqHeader) {
        const answer = faqHeader.nextElementSibling;
        if (answer.style.display === "none" || answer.style.display === "") {
            answer.style.display = "block";
        } else {
            answer.style.display = "none";
        }
    }
</script>

</body>
</html>
