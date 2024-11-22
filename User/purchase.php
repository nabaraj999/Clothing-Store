<?php
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

// Retrieve product_id from POST request
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;

// Fetch the product details from the database
if ($product_id > 0) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the product data
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Load CSS for Slick Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="index.css">
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
    <?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
        <span id="username"><?php echo htmlspecialchars($username); ?></span> <!-- Display the username -->
        <a href="logout.php" id="logout-link" class="logout-button">Logout</a> <!-- Styled logout button -->
    </div>
</div>

    </div>
</header>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .product-details-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .product-details-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .product-details-card img {
            width: 200px;
            height: 250px;
            max-height: 250px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-details-card h2 {
            font-size: 1.5em;
            margin-top: 15px;
            color: #333;
        }

        .product-details-card p {
            font-size: 1.1em;
            color: #555;
            margin: 10px 0;
        }

        .price {
            font-size: 1.4em;
            color: #4CAF50;
            font-weight: bold;
        }

        .purchase-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }

        .purchase-button:hover {
            background-color: #3e8e41;
        }

    </style>
</head>
<body>

<div class="product-details-container">
    <?php if (isset($product)): ?>
        <div class="product-details-card">
            <img src="<?php echo '../uploads/' . $product['front_photo']; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <!-- Check if the description exists -->
            <p><?php echo isset($product['description']) && !empty($product['description']) ? nl2br(htmlspecialchars($product['description'])) : 'No description available for this product.'; ?></p>
            <p class="price">NPR <?php echo number_format($product['price'], 2); ?></p>
            <form action="checkout_handler.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit" class="purchase-button">Proceed to Checkout</button>
</form>

        </div>
    <?php else: ?>
        <p>Product details could not be loaded.</p>
    <?php endif; ?>
</div>

</body>
</html>
