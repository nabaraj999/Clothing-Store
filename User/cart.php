<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve cart from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total price
$total = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cart));

// Add delivery charge
$deliveryCharge = 80;
$totalWithDelivery = $total + $deliveryCharge;

// Handle remove item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $productToRemove = $_POST['remove'];
    if (isset($cart[$productToRemove])) {
        unset($cart[$productToRemove]);
        $_SESSION['cart'] = $cart;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 1.5em;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
            padding: 15px;
            text-align: right;
        }

        .actions {
            text-align: center;
            padding: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            font-weight: bold;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .remove-btn {
            background-color: #e74c3c;
        }

        .remove-btn:hover {
            background-color: #c0392b;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            font-size: 1.2em;
            color: #888;
        }

        .payment-options {
            padding: 20px;
            text-align: center;
        }

        .address-form {
            display: none;
            text-align: left;
            padding: 20px;
        }

        .address-form input, .address-form textarea, .address-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
    <script>
        function showPaymentOption(option) {
            const addressForm = document.getElementById('address-form');
            const notAvailableMessage = document.getElementById('not-available-message');

            if (option === 'cash') {
                addressForm.style.display = 'block';
                notAvailableMessage.style.display = 'none';
            } else {
                addressForm.style.display = 'none';
                notAvailableMessage.style.display = 'block';
            }
        }
    </script>
</head>
<body>
<header>Your Shopping Cart</header>
<div class="container">
    <?php if (count($cart) > 0): ?>
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $key => $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>NPR <?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>NPR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <form method="POST">
                            <button class="btn remove-btn" name="remove" value="<?php echo $key; ?>">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="total">Total: NPR <?php echo number_format($total, 2); ?></div>
        <div class="total">Delivery Charge: NPR <?php echo number_format($deliveryCharge, 2); ?></div>
        <div class="total">Grand Total: NPR <?php echo number_format($totalWithDelivery, 2); ?></div>
        <div class="payment-options">
            <h3>Select Payment Method</h3>
            <button class="btn" onclick="showPaymentOption('cash')">Cash on Delivery</button>
            <button class="btn" onclick="showPaymentOption('online')">Online Payment</button>
        </div>
        <div id="not-available-message" style="text-align: center; display: none; color: red;">Online payment is currently not available.</div>
        <form id="address-form" class="address-form" method="POST" action="process_order.php">
            <h3>Delivery Address</h3>
            <label for="product-name">Product Name:</label>
            <input type="text" id="product-name" name="product_name" value="<?php echo implode(', ', array_column($cart, 'name')); ?>" readonly>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>

            <label for="district">Select District:</label>
            <select id="district" name="district" required>
                <option value="">-- Select District --</option>
                <option value="Kathmandu">Kathmandu</option>
                <option value="Lalitpur">Lalitpur</option>
                <option value="Bhaktapur">Bhaktapur</option>
                <!-- Add more districts as needed -->
            </select>

            <label for="address">Full Address:</label>
            <textarea id="address" name="address" rows="4" required></textarea>

            <label for="total">Total Amount:</label>
            <input type="text" id="total" name="total" value="<?php echo number_format($totalWithDelivery, 2); ?>" readonly>

            <label for="quantity">Quantity:</label>
            <input type="text" id="quantity" name="quantity" value="<?php echo implode(', ', array_column($cart, 'quantity')); ?>" readonly>

            <button type="submit" class="btn">Submit Order</button>
        </form>
    <?php else: ?>
        <div class="empty-cart">Your cart is empty. Start shopping now!</div>
    <?php endif; ?>
</div>
</body>
</html>
