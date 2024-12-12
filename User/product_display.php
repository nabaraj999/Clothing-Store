
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs";

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

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Load CSS for Slick Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="product_display.css">
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
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.product-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Ensures there are 5 cards in each row */
    gap: 10px; /* Sets a 10px gap between cards */
    padding: 10px;
    max-width: 1200px;
    margin: auto;
}

.product-card {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    margin: 0; /* No margin to reduce extra space */
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 100%; /* Ensures the image fills the width */
    height: 180px;
    overflow: hidden;
    border-radius: 8px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-card h3 {
    font-size: 1em;
    margin: 10px 0 5px;
    color: #333;
}

.product-card p {
    font-size: 0.9em;
    color: #666;
    margin: 5px 0;
}

.purchase-button {
    padding: 8px 12px;
    background-color: #6C63FF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9em;
    transition: background 0.3s ease;
}

.purchase-button:hover {
    background-color: #5848cc;
}

/* Additional styles for filter buttons */
.filter-buttons form {
    display: inline-block;
    margin: 0;
}

.filter-buttons button {
    padding: 8px 16px;
    background-color: #6C63FF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    margin-right: 10px; /* Small margin between filter buttons */
    transition: background 0.3s ease;
}

.filter-buttons button:hover {
    background-color: #5848cc;
}

.filter-buttons .active {
    background-color: #4e42c1;
}


    </style>

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
</body>
</html>
