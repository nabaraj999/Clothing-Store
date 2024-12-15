<?php
session_start();

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

// Sanitize input data
$productName = $conn->real_escape_string($_POST['product_name']);
$username = $conn->real_escape_string($_POST['username']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$district = $conn->real_escape_string($_POST['district']);
$address = $conn->real_escape_string($_POST['address']);
$total = $conn->real_escape_string($_POST['total']);
$quantity = $conn->real_escape_string($_POST['quantity']); // Use a separate variable for quantity

// Insert order into database
$sql = "INSERT INTO orders (username, product_name, phone, email, district, address, total_amount, quantity, order_date) 
        VALUES ('$username', '$productName', '$phone', '$email', '$district', '$address', '$total', '$quantity', NOW())";

if ($conn->query($sql) === TRUE) {
    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to success page or show success message
    echo "<script>alert('Order placed successfully!'); window.location.href='thank_you.php';</script>";
} else {
    echo "<script>alert('Error placing order: " . $conn->error . "'); window.history.back();</script>";
}

// Close connection
$conn->close();
?>
