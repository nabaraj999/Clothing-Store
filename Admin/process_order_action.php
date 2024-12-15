<?php
include ('db_connect.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = intval($_POST['order_id']);
    $productName = $conn->real_escape_string($_POST['product_name']);
    $quantity = intval($_POST['quantity']);
    $action = $_POST['action'];

    if ($action === 'accepted') {
        // Reduce stock in the products table
        $stockUpdateQuery = "UPDATE products SET stock = stock - $quantity WHERE product_name = '$productName' AND stock >= $quantity";
        if ($conn->query($stockUpdateQuery) === TRUE) {
            // Update order status to 'Approved'
            $orderUpdateQuery = "UPDATE orders SET status = 'Accepted' WHERE id = $orderId";
            $conn->query($orderUpdateQuery);
            echo "<script>alert('Order approved and stock updated.'); window.location.href='admin_orders.php';</script>";
        } else {
            echo "<script>alert('Error updating stock: insufficient stock or invalid product.'); window.history.back();</script>";
        }
    } elseif ($action === 'reject') {
        // Update order status to 'Rejected'
        $orderUpdateQuery = "UPDATE orders SET status = 'Rejected' WHERE id = $orderId";
        $conn->query($orderUpdateQuery);
        echo "<script>alert('Order rejected successfully.'); window.location.href='admin_orders.php';</script>";
    }
}

$conn->close();
?>
