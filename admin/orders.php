<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Secure status update
if (isset($_POST['order_id'], $_POST['status'])) {
    $id = intval($_POST['order_id']);
    $allowed_status = ['Pending', 'Completed'];

    if (in_array($_POST['status'], $allowed_status)) {
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$id");
    }
}

// Fetch orders
$orders = mysqli_query(
    $conn,
    "SELECT o.*, u.email 
     FROM orders o 
     LEFT JOIN users u ON o.user_id = u.id 
     ORDER BY o.created_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Orders - KickZone</title>
<link rel="stylesheet" href="admin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <?php include "sidebar.php"; ?>

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">
            <h2>Manage Orders</h2>
            <div>Admin: <?php echo htmlspecialchars($_SESSION['admin']); ?></div>
        </div>

        <!-- TABLE -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($o = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td>#<?php echo $o['id']; ?></td>
                        <td><?php echo htmlspecialchars($o['email'] ?? 'Unknown'); ?></td>
                        <td>₹<?php echo number_format($o['total_price'], 2); ?></td>
                        <td><?php echo date("d M Y", strtotime($o['created_at'])); ?></td>

                        <td>
                            <span class="status-badge <?php echo strtolower($o['status']); ?>">
                                <?php echo $o['status']; ?>
                            </span>
                        </td>

                        <td>
                            <form method="post" class="status-form">
                                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                                <select name="status" class="admin-select">
                                    <option value="Pending" <?php if($o['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Completed" <?php if($o['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <button type="submit" class="admin-btn small-btn">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </form>
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