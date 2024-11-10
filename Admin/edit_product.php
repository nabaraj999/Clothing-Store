<?php
include 'db_connect.php';

// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product's current details
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit;
}

// Initialize variables
$product_name = $product['product_name'];
$price = $product['price'];
$discount = $product['discount'];
$stock = $product['stock'];
$front_photo = $product['front_photo'];
$back_photo = $product['back_photo'];

// Handle form submission to update the product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $stock = $_POST['stock'];

    // Handle image upload for front and back photos
    $upload_dir = '../uploads/';
    $front_photo = $_FILES['front_photo']['name'] ? $_FILES['front_photo']['name'] : $product['front_photo'];
    $back_photo = $_FILES['back_photo']['name'] ? $_FILES['back_photo']['name'] : $product['back_photo'];

    // Check if the images are uploaded and move them to the correct directory
    if ($_FILES['front_photo']['name']) {
        move_uploaded_file($_FILES['front_photo']['tmp_name'], $upload_dir . $front_photo);
    }

    if ($_FILES['back_photo']['name']) {
        move_uploaded_file($_FILES['back_photo']['tmp_name'], $upload_dir . $back_photo);
    }

    // Update the database with new values
    $sql = "UPDATE products SET 
            product_name = '$product_name', 
            price = $price, 
            discount = $discount, 
            stock = $stock, 
            front_photo = '$front_photo', 
            back_photo = '$back_photo' 
            WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
        echo "Product updated successfully.";
        header("Location: manage_products.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            text-align : center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 1.1em;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="file"] {
            padding: 5px;
        }

        .btn {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .btn:hover {
            background-color: #4cae4c;
        }

        .form-group img {
            width: 100px;
            height: auto;
            margin-top: 10px;
        }

        .form-group .img-preview {
            margin-top: 10px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-actions button {
            width: 48%;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required step="0.01">
        </div>

        <div class="form-group">
            <label for="discount">Discount (%) :</label>
            <input type="number" id="discount" name="discount" value="<?php echo $product['discount']; ?>" step="0.01">
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
        </div>

        <div class="form-group">
            <label for="front_photo">Front Photo:</label>
            <input type="file" id="front_photo" name="front_photo">
            <?php if ($product['front_photo']) : ?>
                <div class="img-preview">
                    <img src="uploads/<?php echo $product['front_photo']; ?>" alt="Front Photo">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="back_photo">Back Photo:</label>
            <input type="file" id="back_photo" name="back_photo">
            <?php if ($product['back_photo']) : ?>
                <div class="img-preview">
                    <img src="uploads/<?php echo $product['back_photo']; ?>" alt="Back Photo">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" name="update_product" class="btn">Update Product</button>
        </div>
    </form>
</div>

</body>
</html>
