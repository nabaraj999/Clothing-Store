<?php
include 'db_connect.php';

// Handle form submission to add a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file uploads
    $front_photo = null;
    $back_photo = null;
    
    if (!empty($_FILES['front_photo']['name'])) {
        $front_photo = 'uploads/' . basename($_FILES['front_photo']['name']);
        move_uploaded_file($_FILES['front_photo']['tmp_name'], $front_photo);
    }
    if (!empty($_FILES['back_photo']['name'])) {
        $back_photo = 'uploads/' . basename($_FILES['back_photo']['name']);
        move_uploaded_file($_FILES['back_photo']['tmp_name'], $back_photo);
    }

    $sql = "INSERT INTO products (product_name, description, price, front_photo, back_photo) VALUES ('$product_name', '$description', $price, '$front_photo', '$back_photo')";
    mysqli_query($conn, $sql);
}

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
       .form-container{
        margin-left: px;
        padding: 20px;
        border-radius: 10px;
       
       }
        h2 , h3{
            color: #333;
            text-align: center;
        }
        form, table {
            width: 100%;
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        img {
            max-width: 60px;
            border-radius: 5px;
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --bg-light: #f4f7fa;
            --text-dark: #333;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: width 0.3s ease;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .navbar-top {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            
            .main-content {
                margin-left: 60px;
            }
            
            .sidebar .nav-link span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar">
                <div class="position-sticky">
                    <a class="navbar-brand d-block text-center my-4 text-white" href="#">
                        <i class="fas fa-shield-alt"></i> Admin
                    </a>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="Admin.php">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_users.php">
                                <i class="fas fa-users"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_products.php">
                                <i class="fas fa-box"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_orders.php">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback.php">
                                <i class="fas fa-user"></i>
                                <span>Feedback</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-top mb-4 rounded">
                    <div class="container-fluid">
                        <h2 class="navbar-brand">Dashboard Overview</h2>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="text-muted">Welcome, Admin</span>
                            </div>
                            <a href="logout.php" class="btn btn-sm logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </nav>
<!-- Add Product Form -->
<div class="form-container">
        
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <h2>Add New Product</h2>
            <label for="product-name">Product Name:</label>
            <input type="text" id="product-name" name="product_name" required>

            <label for="stock">Number of Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="size">Size:</label>
            <select id="size" name="size" required>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
                <option value="3XL">3XL</option>
                <option value="4XL">4XL</option>
                <option value="5XL">5XL</option>
            </select>

            <label for="color">Color:</label>
            <select id="color" name="color" required>
                <option value="Red">Red</option>
                <option value="White">White</option>
                <option value="Black">Black</option>
                <option value="Pink">Pink</option>
                <option value="Yellow">Yellow</option>
                <option value="Blue">Blue</option>
                <option value="Baby Pink">Baby Pink</option>
                <option value="Sky Blue">Sky Blue</option>
                <option value="Green">Green</option>
                <option value="Orange">Orange</option>
            </select>

            <label for="gender">For:</label>
            <select id="gender" name="gender" required>
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Both">Both</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="discount">Discount (%):</label>
            <input type="number" id="discount" name="discount">

            <!-- Front Photo Upload -->
            <label for="front-photo">Front Photo:</label>
            <input type="file" id="front-photo" name="front_photo" required>

            <!-- Back Photo Upload -->
            <label for="back-photo">Back Photo:</label>
            <input type="file" id="back-photo" name="back_photo" required>

            <button type="submit">Add Product</button>
        </form>

<!-- Display Products -->
<h3>Existing Products</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Front Photo</th>
        <th>Back Photo</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
                <?php if ($row['front_photo']) : ?>
                    <img src="<?php echo $row['front_photo']; ?>" alt="Front Photo">
                <?php else : ?>
                    No Image
                <?php endif; ?>
            </td>
            <td>
                <?php if ($row['back_photo']) : ?>
                    <img src="<?php echo $row['back_photo']; ?>" alt="Back Photo">
                <?php else : ?>
                    No Image
                <?php endif; ?>
            </td>
            <td><?php echo $row['product_name']; ?></td>
            <td>$<?php echo number_format($row['price'], 2); ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
