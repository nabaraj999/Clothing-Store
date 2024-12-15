<?php
session_start();

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="product_display.css">
</head>
<body>
<!-- Header Section -->
<header class="header">
    <div class="logo">Fashion Loft</div>
    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="product_display.php">Shop</a>
        <a href="About.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="help.php">Help</a>
    </nav>
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
                <?php
                $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
                ?>
                <span id="username"><?php echo htmlspecialchars($username); ?></span>
                <a href="logout.php" id="logout-link" class="logout-button">Logout</a>
            </div>
        </div>
    </div>
</header>

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
                <div class="cart-form">
                    <input type="hidden" class="product-id" value="<?php echo $product['id']; ?>">
                    <button onclick="addToCart(this)" class="purchase-button">Add to Cart</button>
                    <a href="purchase.php?id=<?php echo $product['id'];?>" class="view-details-button">View Details</a>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available for this category.</p>
    <?php endif; ?>
</div>

<script>
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
</script>
</body>
</html>