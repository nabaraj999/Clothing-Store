<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; // Adjust based on your database setup
$dbname = "cs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    die("Please log in to proceed.");
}

// Fetch the user_id from the session username
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

$user_id = $user['id'];

// Get the product_id from the POST request
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($product_id <= 0) {
    die("Invalid product ID.");
}

// Add the product to the checkout table
$sql = "INSERT INTO checkout (user_id, product_id, quantity) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$quantity = 1; // Default quantity
$stmt->bind_param("iii", $user_id, $product_id, $quantity);

if ($stmt->execute()) {
    echo "Product successfully added to checkout!";
    // Redirect to the checkout view
    header("Location: checkout_view.php");
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
