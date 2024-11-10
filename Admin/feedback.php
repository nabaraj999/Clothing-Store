<?php
include 'db_connect.php';

$result = mysqli_query($conn, "SELECT * FROM contact_messages");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <link rel="stylesheet" href="Admin.css">
</head>
<body>

<div class="admin-panel">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="Admin.php">Dashboard</a></li>
        <li><a href="manage_users.php">User Management</a></li>
        <li><a href="manage_products.php">Product Management</a></li>
        <li><a href="feedback.php">Feedback</a></li>
    </ul>

    <!-- Logout Button -->
    <div class="logout-btn">
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>
    <!-- Main Content Area -->
    
</div>
    <style>
        /* General Styling */
        

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #2c3e50;
        }

        .container {
            width: 70%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-left: 350px;
            margin-top:-50%;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f0e68c;
        }

        /* Button Style */
        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Pagination Styling */
        .pagination {
            list-style: none;
            padding: 0;
            text-align: center;
            margin-top: 20px;
        }

        .pagination li {
            display: inline-block;
            margin: 0 5px;
        }

        .pagination a {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Feedback</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Feedback</th>
            <th>Date</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Optional Pagination (if needed) -->
    <!-- <ul class="pagination">
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
    </ul> -->

</div>

</body>
</html>
