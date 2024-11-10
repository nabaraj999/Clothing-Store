<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
            <span class="cart-count" id="cart-count">0</span>
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 20px;
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .contact-form {
            flex: 1;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .contact-form h2 {
            margin-top: 0;
            font-size: 2em;
            color: #333;
        }

        .contact-form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .contact-form textarea {
            resize: vertical;
            height: 150px;
        }

        .contact-form button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
        }

        .contact-form button:hover {
            background-color: #45a049;
        }

        .contact-info {
            flex: 1;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .contact-info h2 {
            margin-top: 0;
            font-size: 2em;
            color: #333;
        }

        .contact-info p {
            margin: 10px 0;
            line-height: 1.6;
            color: #555;
        }

        .contact-info .info-item {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .contact-info .info-item i {
            font-size: 1.5em;
            color: #4CAF50;
            margin-right: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Contact Form Section -->
        <div class="contact-form">
            <h2>Contact Us</h2>
            <form action="submit_contact_form.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <!-- Contact Information Section -->
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p>If you have any questions, feel free to reach out to us. We would love to hear from you!</p>

            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <p>(+1) 123-456-7890</p>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <p>contact@example.com</p>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>1234 Fashion Ave, New York, NY 10001</p>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    
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


</body>
</html>
