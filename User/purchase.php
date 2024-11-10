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

$product_id = 2; // Example product ID, replace or set dynamically as needed

// Fetch product data
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="purchase.php">
    <style>
    
        .product-detail-container {
            display: flex;
            max-width: 1000px;
            gap: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-left: 20%;
            margin-top: 2%;
        }
        .product-images {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .thumbnail-images img {
            width: 80px;
            height: auto;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .main-image img {
            width: 300px;
            height: auto;
            border-radius: 8px;
        }
        .product-info {
            flex: 1;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .product-info h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
            font-weight: bold;
            color: #3a3a3a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .product-info .price {
            font-size: 24px;
            color: #6C63FF;
            font-weight: bold;
        }
        .thank-you-message {
            font-size: 18px;
            color: #555;
            font-style: italic;
            margin-top: 10px;
        }
        .product-options select {
            padding: 12px;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
        }
        .quantity-control, .add-to-cart {
            display: none; /* Hidden until size and color are selected */
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }
        .quantity-control button {
            padding: 8px 12px;
            font-size: 18px;
            cursor: pointer;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .quantity-control input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .add-to-cart {
            padding: 14px 24px;
            background-color: #6C63FF;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .add-to-cart:hover {
            background-color: #5848cc;
        }
    </style>
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
        <span id="username"><?php echo htmlspecialchars($username); ?></span> <!-- Display the username -->
        <a href="logout.php" id="logout-link" class="logout-button">Logout</a> <!-- Styled logout button -->
    </div>
</div>
</header>

<div class="product-detail-container">
    <?php if (!$product): ?>
        <p>Product not found.</p>
    <?php else: ?>
    <!-- Product Images Section -->
    <div class="product-images">
        <div class="thumbnail-images">
            <?php
            $thumbnails = [$product['front_photo'], $product['back_photo']];
            foreach ($thumbnails as $thumb) {
                if ($thumb) {
                    echo "<img src='$thumb' onclick='updateMainImage(\"$thumb\")'>";
                }
            }
            ?>
        </div>
        <div class="main-image">
            <img id="mainProductImage" src="<?php echo $product['front_photo']; ?>" alt="Product Image">
        </div>
    </div>

    <!-- Product Info Section -->
    <div class="product-info">
        <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
        
        <!-- Thank You Message -->
        <p class="thank-you-message">Thank you for your purchase! Enjoy your new item.</p>

        <!-- Size and Color Options -->
       <!-- Size and Color Options -->
<div class="product-options">
    <label for="size">Size</label>
    <select id="size" onchange="checkSelection()">
        <option value="">Choose an option</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
        <option value="3XL">3XL</option>
        <option value="4XL">4XL</option>
        <option value="5XL">5XL</option>
    </select>

    <label for="color">Color</label>
    <select id="color" onchange="checkSelection()">
        <option value="">Choose an option</option>
        <option value="Red">Red</option>
        <option value="White">White</option>
        <option value="Black">Black</option>
        <option value="Pink">Pink</option>
        <option value="Yellow">Yellow</option>
        <option value="Blue">Blue</option>
        <option value="Baby Pink">Baby Pink</option>
        <option value="Sky Blue">Sky Blue</option>
        <option value="Green">Green</option>
        <option value="Orange">Orange</option>
    </select>
</div>


        <!-- Quantity Control (hidden by default) -->
        <div class="quantity-control" id="quantityControl">
            <button onclick="changeQuantity(-1)">-</button>
            <input type="text" id="quantity" value="1">
            <button onclick="changeQuantity(1)">+</button>
        </div>

        <!-- Add to Cart Button (hidden by default) -->
        <button class="add-to-cart" id="addToCartButton">Add to Cart</button>
    </div>
    <?php endif; ?>
</div>

<script>
    // Function to update the main image
    function updateMainImage(imageUrl) {
        document.getElementById('mainProductImage').src = imageUrl;
    }

    // Show quantity and add to cart button only after selecting size and color
    function checkSelection() {
        const size = document.getElementById('size').value;
        const color = document.getElementById('color').value;
        const quantityControl = document.getElementById('quantityControl');
        const addToCartButton = document.getElementById('addToCartButton');

        if (size && color) {
            quantityControl.style.display = 'flex';
            addToCartButton.style.display = 'block';
        } else {
            quantityControl.style.display = 'none';
            addToCartButton.style.display = 'none';
        }
    }

    // Function to adjust quantity
    function changeQuantity(amount) {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        quantity = Math.max(1, quantity + amount);
        quantityInput.value = quantity;
    }

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
        window.location.href = 'cart.php';
    }

    
    
    
    document.getElementById('addToCartButton').addEventListener('click', function() {
    const size = document.getElementById('size').value;
    const color = document.getElementById('color').value;
    const quantity = parseInt(document.getElementById('quantity').value);

    // Ensure size and color are selected
    if (!size || !color) {
        alert("Please select size and color before adding to cart.");
        return;
    }

    // Product details
    const productDetails = {
        product_id: <?php echo $product_id; ?>,
        product_name: "<?php echo htmlspecialchars($product['product_name']); ?>",
        size: size,
        color: color,
        quantity: quantity,
        price: <?php echo $product['price']; ?>,
        total_price: (<?php echo $product['price']; ?> * quantity).toFixed(2)
    };

    // Save to localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(productDetails);
    localStorage.setItem('cart', JSON.stringify(cart));

    // Redirect to the cart page
    window.location.href = 'cart.php';
});

</script>

</body>
</html>
