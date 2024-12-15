    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection
    require_once 'database.php';

    class AdminDashboard {
        private $db;

        public function __construct(DatabaseConnection $db) {
            $this->db = $db;
        }

        public function getStats(): array {
            return [
                'total_users' => $this->getCount("users"),
                'total_products' => $this->getCount("products"),
                'pending_orders' => $this->getCount("orders", "status = 'pending'"),
                'recent_orders' => $this->getRecentOrders()
            ];
        }

        private function getCount(string $table, string $condition = "1=1"): int {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM $table WHERE $condition");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc()['total'] ?? 0;
        }

        private function getRecentOrders(): array {
            $stmt = $this->db->prepare("SELECT id, total_amount FROM orders ORDER BY order_date DESC LIMIT 5");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    $db = new DatabaseConnection();
    $dashboard = new AdminDashboard($db);
    $stats = $dashboard->getStats();
    ?>
<!DOCTYPE html>
<html lang="en">
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

                <!-- Dashboard Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card dashboard-card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text display-6"><?= $stats['total_users'] ?></p>
                                <small class="text-light">Active Users</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card dashboard-card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <p class="card-text display-6"><?= $stats['total_products'] ?></p>
                                <small class="text-light">In Inventory</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card dashboard-card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Pending Orders</h5>
                                <p class="card-text display-6"><?= $stats['pending_orders'] ?></p>
                                <small class="text-light">Awaiting Fulfillment</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">Recent Orders</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recent_orders'] as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id']) ?></td>
                                        <td>NPR <?= number_format($order['total_amount'], 2) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='admin_orders.php'">
                                                    <i class="fas fa-eye"></i> View
                                                          </button>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     <script>
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default behavior of the link
        window.location.href = 'logout.php'; // Redirect to logout.php
    });
</script>

    </script>
</body>
</html>