<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
     <!-- Load Font Awesome for Icons -->
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
        /* Add your CSS here */
        .cart-container2 {
            padding: 30px;
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        th {
            background-color: #6C63FF;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #fafafa;
        }

        .remove-btn {
            background-color: #FF4D4D;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #e63939;
        }

        .total-price {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        .payment-form {
            margin-top: 20px;
        }

        .payment-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .payment-form input, .payment-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .payment-form button {
            padding: 12px 20px;
            background-color: #6C63FF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .payment-form button:hover {
            background-color: #5a54e6;
        }

        .cart-container h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

<div class="cart-container2">
    <h2>Your Cart</h2>

    <table id="cart-items">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Cart items will be dynamically inserted here -->
        </tbody>
    </table>

    <div class="total-price">
        Total Price: $<span id="total-price">0.00</span>
    </div>

    <!-- Payment Form -->
    <div class="payment-form">
        <h3>Payment Information</h3>
        <form id="payment-form">

            <label for="username">Username</label>
            <input type="text" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled> 

            <label for="email">Email Address</label>
            <input type="email" id="email" placeholder="you@example.com" required>

            <label for="card-name">Name on Card</label>
            <input type="text" id="card-name" placeholder="John Doe" required>

            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" placeholder="1234 5678 9876 5432" required>

            <label for="expiry-date">Expiry Date</label>
            <input type="month" id="expiry-date" required>

            <label for="cvv">CVV</label>
            <input type="text" id="cvv" placeholder="123" required>

            <button type="submit">Proceed to Checkout</button>
        </form>
    </div>
</div>

<script>
// Retrieve cart data from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Display cart items in the table
const cartItemsContainer = document.getElementById('cart-items').getElementsByTagName('tbody')[0];
let totalPrice = 0;

function updateCart() {
    cartItemsContainer.innerHTML = ''; // Clear existing rows
    totalPrice = 0; // Reset total price

    cart.forEach((item, index) => {
        const row = cartItemsContainer.insertRow();

        // Populate row data
        row.innerHTML = `
            <td>${item.product_name}</td>
            <td>${item.size}</td>
            <td>${item.color}</td>
            <td>
                <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input">
            </td>
            <td>$${item.price}</td>
            <td>$${(item.quantity * item.price).toFixed(2)}</td>
            <td>
                <button class="remove-btn" data-index="${index}">Remove</button>
            </td>
        `;

        // Update total price
        totalPrice += item.quantity * item.price;
    });

    document.getElementById('total-price').textContent = totalPrice.toFixed(2);

    // Save updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Handle quantity change
cartItemsContainer.addEventListener('input', function (e) {
    if (e.target.classList.contains('quantity-input')) {
        const index = e.target.getAttribute('data-index');
        cart[index].quantity = parseInt(e.target.value) || 1;
        updateCart();
    }
});

// Handle remove button click
cartItemsContainer.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-btn')) {
        const index = e.target.getAttribute('data-index');
        cart.splice(index, 1); // Remove item from cart
        updateCart();
    }
});

// Initial render
updateCart();

// Handle payment form submission
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const cardName = document.getElementById('card-name').value;
    const cardNumber = document.getElementById('card-number').value;

    // Process payment (placeholder logic)
    alert(`Payment of $${totalPrice.toFixed(2)} has been processed successfully for ${email}.`);

    // Clear the cart and redirect
    localStorage.removeItem('cart');
    window.location.href = 'confirmation.php';
});
</script>

</body>
</html>
