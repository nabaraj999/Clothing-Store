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

// Validate product ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    header("Location: product_display.php");
    exit;
}

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: product_display.php");
    exit;
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
    <link rel="stylesheet" href="purchase.css">
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        
        .product-details-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            border-radius: 10px;
            max-width: 800px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .product-image img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
        }
        .product-info {
            flex: 1;
            margin-left: 20px;
        }
        .product-info h1 {
            font-size: 28px;
            color: #333;
        }
        .price {
            font-size: 24px;
            color: #e67e22;
            margin: 10px 0;
        }
        .description {
            font-size: 16px;
            color: #555;
        }
        .add-to-cart-button {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-to-cart-button:hover {
            background-color: #2ecc71;
        }
        .add-to-cart-button.added {
            background-color: #3498db;
        }
    </style>
</head>
<body>
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

<div class="product-details-container">
    <div class="product-image">
        <img src="<?php echo !empty($product['front_photo']) ? '../uploads/' . $product['front_photo'] : 'placeholder.png'; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
    </div>
    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
        <p class="price">NPR <?php echo number_format($product['price'], 2); ?></p>
        <p>Discount: <?php echo htmlspecialchars($product['discount']);?>%</p>
        <p>Color: <?php echo htmlspecialchars($product['color']);?></p>
        <p>Size: <?php echo htmlspecialchars($product['size']);?></p>
        <p>Stock: <?php echo htmlspecialchars($product['stock']);?></p>
        <p>For: <?php echo htmlspecialchars($product['gender']);?></p>
        
        <p class="description"> <?php echo htmlspecialchars($product['description']); ?></p>
        <div class="cart-form">
            <input type="hidden" class="product-id" value="<?php echo $product['id']; ?>">
            <button onclick="addToCart(this)" class="add-to-cart-button">Add to Cart</button>
        </div>
    </div>
</div>

<script>
function addToCart(button) {
    // Get the product ID from the hidden input
    const productId = button.parentElement.querySelector('.product-id').value;

    // Initialize the XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Handle the server response
    xhr.onload = function () {
        try {
            // Parse the JSON response
            const response = JSON.parse(xhr.responseText);

            if (xhr.status === 200 && response.status === "success") {
                // Update cart count on the header
                document.querySelector(".cart-count").textContent = response.cartCount;

                // Provide user feedback
                button.textContent = "Added!";
                button.classList.add("added");

                // Reset button text and style after 1.5 seconds
                setTimeout(() => {
                    button.textContent = "Add to Cart";
                    button.classList.remove("added");
                }, 1500);
            } else {
                // Handle specific errors (e.g., unauthenticated user)
                if (xhr.status === 401) {
                    window.location.href = "login.php"; // Redirect to login if unauthorized
                } else {
                    // Display error message from server
                    alert(response.message || "An error occurred while adding to the cart.");
                }
            }
        } catch (error) {
            // Handle invalid or unexpected server responses
            console.error("Error parsing server response:", xhr.responseText);
            alert("An unexpected error occurred. Please try again later.");
        }
    };

    // Handle network errors
    xhr.onerror = function () {
        alert("Unable to connect to the server. Please check your internet connection and try again.");
    };

    // Send the product ID to the server
    xhr.send("id=" + encodeURIComponent(productId));
}

function redirectToCart() {
    // Navigate to the cart page
    window.location.href = "cart.php";
}

</script>
</body>
</html>
