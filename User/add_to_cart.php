<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Ensure cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized. Please log in.']);
    exit;
}

// Get product ID from the request
$productId = isset($_POST['id']) ? intval($_POST['id']) : null;

if (!$productId) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// Check cart limit
if (count($_SESSION['cart']) >= 7 && !isset($_SESSION['cart'][$productId])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Maximum cart limit reached']);
    exit;
}

// Fetch product details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement']);
    exit;
}
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    exit;
}

// Add product to cart
if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] = [
        'id' => $product['id'],
        'name' => $product['product_name'],
        'price' => $product['price'],
        'quantity' => 1,
    ];
} else {
    $_SESSION['cart'][$productId]['quantity']++;
}

// Update cart count
$_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

// Respond with updated cart count
echo json_encode(['status' => 'success', 'cartCount' => $_SESSION['cart_count']]);

// Close database connection
$stmt->close();
$conn->close();
?>
