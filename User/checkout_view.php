<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username']; // Retrieve username from session

// Database connection
$servername = "localhost";
$usernameDB = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "cs"; // Update as needed

$conn = new mysqli($servername, $usernameDB, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user ID using the username from the session
$sql_user = "SELECT id FROM users WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

$user_id = $user['id'];

// Fetch products in the checkout
$sql = "SELECT c.*, p.product_name, p.price, p.front_photo 
        FROM checkout c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle "Remove" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $remove_id = $_POST['remove_id'];
    
    // Remove the product from the checkout
    $remove_sql = "DELETE FROM checkout WHERE id = ?";
    $stmt_remove = $conn->prepare($remove_sql);
    $stmt_remove->bind_param("i", $remove_id);
    $stmt_remove->execute();
    $stmt_remove->close();
    header("Location: checkout_view.php"); // Refresh the page after removal
    exit;
}

// Handle "Clear Cart" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    $clear_sql = "DELETE FROM checkout WHERE user_id = ?";
    $stmt_clear = $conn->prepare($clear_sql);
    $stmt_clear->bind_param("i", $user_id);
    $stmt_clear->execute();
    $stmt_clear->close();
    header("Location: checkout_view.php"); // Refresh the page after clearing the cart
    exit;
}

// Handle "Pay Now" action (process all items)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    // Process the payment (you can integrate payment gateway here)
    
    // After payment, delete all items from the checkout
    $pay_sql = "DELETE FROM checkout WHERE user_id = ?";
    $stmt_pay = $conn->prepare($pay_sql);
    $stmt_pay->bind_param("i", $user_id);
    $stmt_pay->execute();
    $stmt_pay->close();
    header("Location: checkout_view.php"); // Redirect after successful payment
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Checkout</title>
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
    
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid #ddd;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .product-details {
            display: flex;
            align-items: center;
        }
        .product-details img {
            width: 70px;
            height: 70px;
            margin-right: 15px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .product-price {
            font-size: 16px;
            color: #4CAF50;
            font-weight: bold;
        }
        .checkout-footer {
            text-align: right;
            margin-top: 20px;
        }
        .pay-now-button, .remove-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .pay-now-button:hover {
            background-color: #45a049;
        }
        .remove-button {
            background-color: #f44336;
            margin-left: 10px;
        }
        .remove-button:hover {
            background-color: #d32f2f;
        }
        .clear-cart-button {
            background-color: #f57c00;
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .clear-cart-button:hover {
            background-color: #e65100;
        }
    </style>
</head>
<body>
    <h1>Your Checkout</h1>
    <div class="checkout-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <div class="product-details">
                        <img src="../uploads/<?php echo htmlspecialchars($row['front_photo']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                        <span class="product-name"><?php echo htmlspecialchars($row['product_name']); ?></span>
                    </div>
                    <div class="product-price">NPR <?php echo number_format($row['price'], 2); ?></div>
                    <form action="checkout_view.php" method="POST" style="display: inline;">
                        <input type="hidden" name="remove_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="remove-button">Remove</button>
                    </form>
                </div>
            <?php endwhile; ?>
            <!-- Pay Now button -->
            <form action="checkout_view.php" method="POST" class="checkout-footer">
                <button type="submit" name="pay_now" class="pay-now-button">Pay Now</button>
            </form>
        <?php else: ?>
            <p>No products in checkout.</p>
        <?php endif; ?>
        <!-- Clear Cart button -->
        <form action="checkout_view.php" method="POST">
            <button type="submit" name="clear_cart" class="clear-cart-button">Clear Cart</button>
        </form>
    </div>

    <?php 
    $stmt_user->close();
    $stmt->close();
    $conn->close(); 
    ?>
</body>
</html>
