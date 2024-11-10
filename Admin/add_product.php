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

// Handle file uploads and set the file paths
$uploadDirectory = "../uploads/"; // Change this to your desired directory

// Function to validate and upload photo
function uploadPhoto($file, $uploadDirectory) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB limit

    // Check if there is an error with the file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error: File upload failed.");
    }

    // Check if file is of valid type
    if (!in_array($file['type'], $allowedTypes)) {
        die("Error: Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    // Check file size
    if ($file['size'] > $maxSize) {
        die("Error: File size exceeds the 5MB limit.");
    }

    // Set file path
    $filePath = $uploadDirectory . basename($file['name']);

    // Move the uploaded file to the desired directory
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return $filePath;
    } else {
        die("Error uploading file: " . $file['name']);
    }
}

// Check if files are uploaded correctly
if (isset($_FILES['front_photo']) && $_FILES['front_photo']['error'] == UPLOAD_ERR_OK) {
    $frontPhotoPath = uploadPhoto($_FILES['front_photo'], $uploadDirectory);
} else {
    die("Error: No front photo uploaded or file upload error.");
}

if (isset($_FILES['back_photo']) && $_FILES['back_photo']['error'] == UPLOAD_ERR_OK) {
    $backPhotoPath = uploadPhoto($_FILES['back_photo'], $uploadDirectory);
} else {
    die("Error: No back photo uploaded or file upload error.");
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO products (product_name, stock, size, color, gender, price, discount, front_photo, back_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisssdsss", $product_name, $stock, $size, $color, $gender, $price, $discount, $frontPhotoPath, $backPhotoPath);

// Set parameters from POST data and execute
$product_name = $_POST['product_name'];
$stock = $_POST['stock'];
$size = $_POST['size'];
$color = $_POST['color'];
$gender = $_POST['gender'];
$price = $_POST['price'];
$discount = $_POST['discount'] ?? 0; // Default to 0 if no discount

if ($stmt->execute()) {
    echo "New product added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
