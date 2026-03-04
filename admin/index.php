<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Dashboard Statistics
$total_products = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM products")
)['total'];

$total_orders = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders")
)['total'];

$pending_orders = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE status='Pending'")
)['total'];

$revenue_result = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total_price) AS revenue FROM orders")
);
$total_revenue = $revenue_result['revenue'] ?? 0;

// Recent Orders
$recent = mysqli_query(
    $conn,
    "SELECT o.*, u.email 
     FROM orders o
     LEFT JOIN users u ON o.user_id = u.id
     ORDER BY o.id DESC 
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - KickZone</title>
<link rel="stylesheet" href="admin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <?php include "sidebar.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP BAR -->
        <div class="topbar">
            <h2>Dashboard</h2>
            <div class="admin-info">
                Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="cards">

            <div class="card">
                <div class="card-icon bg-blue">
                    <i class="fa fa-box"></i>
                </div>
                <div>
                    <h3>Total Products</h3>
                    <p><?php echo number_format($total_products); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon bg-green">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div>
                    <h3>Total Orders</h3>
                    <p><?php echo number_format($total_orders); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon bg-orange">
                    <i class="fa fa-clock"></i>
                </div>
                <div>
                    <h3>Pending Orders</h3>
                    <p><?php echo number_format($pending_orders); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon bg-purple">
                    <i class="fa fa-rupee-sign"></i>
                </div>
                <div>
                    <h3>Total Revenue</h3>
                    <p>₹<?php echo number_format($total_revenue, 2); ?></p>
                </div>
            </div>

        </div>

        <!-- RECENT ORDERS TABLE -->
        <div class="table-section">
            <h3>Recent Orders</h3>

            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($row = mysqli_fetch_assoc($recent)) { ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['email'] ?? 'Unknown'); ?></td>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                    <td>
                        <span class="status-badge <?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>