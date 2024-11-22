<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<?php
session_start();
$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "cs"; // Update as needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: checkout_view.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Assuming you store user ID in the session
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id > 0) {
    // Check if the product already exists in the checkout
    $sql_check = "SELECT * FROM checkout WHERE user_id = ? AND product_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $user_id, $product_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Product already in checkout.";
    } else {
        // Add product to checkout
        $sql_insert = "INSERT INTO checkout (user_id, product_id) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $user_id, $product_id);

        if ($stmt_insert->execute()) {
            echo "Product added to checkout successfully.";
            header("Location: checkout_view.php"); // Redirect to checkout page
            exit;
        } else {
            echo "Error adding product to checkout.";
        }
    }

    $stmt_check->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>
