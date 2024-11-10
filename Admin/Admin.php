<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
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
    <div class="main-content">
        <h1>Welcome to the Admin Panel</h1>
        <p>Select an option from the sidebar to manage the website content.</p>
    </div>
</div>

</body>
</html>
