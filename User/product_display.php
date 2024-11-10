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

// Retrieve gender from request (defaults to "Men" if not provided)
$gender = isset($_GET['gender']) ? $_GET['gender'] : 'Men';

// Fetch products based on the selected gender
$gender = isset($_GET['gender']) ? $_GET['gender'] : 'Men';
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

    <style>
        /* CSS Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .filter-buttons {
            text-align: center;
            margin: 30px 0;
        }

        .filter-buttons button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .filter-buttons button:hover {
            background-color: #45a049;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: hidden;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-image {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
            cursor: pointer;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease-in-out;
        }

        .product-card h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .product-card p {
            font-size: 1.1em;
            color: #333;
        }

        .purchase-button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .purchase-button:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            position: relative;
            margin: 5% auto;
            max-width: 80%;
            text-align: center;
        }

        .modal-content img {
            width: 100%;
            height: auto;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: #fff;
            font-size: 35px;
            cursor: pointer;
        }

        .close:hover {
            color: #bbb;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="index.css">
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


<div class="filter-buttons">
    <!-- Filter for Men -->
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Men">
        <button type="submit">Men</button>
    </form>

    <!-- Filter for Women -->
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Women">
        <button type="submit">Women</button>
    </form>

    <!-- Filter for Both -->
    <form action="product_display.php" method="GET" style="display: inline;">
        <input type="hidden" name="gender" value="Both">
        <button type="submit">Both</button>
    </form>
</div>



<!-- Product Display Section -->
<div class="product-container">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image" onclick="openModal('<?php echo '../uploads/' . $product['front_photo']; ?>')">
                    <img src="<?php echo '../uploads/' . $product['front_photo']; ?>" alt="<?php echo $product['product_name']; ?>" class="front-photo">
                    <img src="<?php echo '../uploads/' . $product['back_photo']; ?>" alt="<?php echo $product['product_name']; ?>" class="back-photo">
                </div>
                <h3><?php echo $product['product_name']; ?></h3>
                <p>$<?php echo number_format($product['price'], 2); ?></p>
                <form action="purchase.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="purchase-button">Purchase</button>
                </form>
            </div>
            
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available for this category.</p>
    <?php endif; ?>
</div>

<!-- Modal for full-size image -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img id="modalImage" src="" alt="Full Size Image">
    </div>
</div>

<script>
  function filterProducts(gender) {
        window.location.href = `product_display.php?gender=${gender}`;
    }

    // Add event listeners to each button
    document.getElementById('menButton').addEventListener('click', function() {
        filterProducts('Men');
    });

    document.getElementById('womenButton').addEventListener('click', function() {
        filterProducts('Women');
    });

    document.getElementById('bothButton').addEventListener('click', function() {
        filterProducts('Both');
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
    


</script>

</body>
</html>
