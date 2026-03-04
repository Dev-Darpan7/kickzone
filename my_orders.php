<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];   // using username (STRING)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders - KickZone</title>
  <link rel="stylesheet" href="shoe.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo"><h2>KickZone</h2></div>
    <ul class="nav-menu">
      <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>
      <li class="nav-item"><a href="my_orders.php" class="nav-link">Orders</a></li>
      <li class="nav-item nav-link">Welcome, <?php echo $_SESSION['user']; ?></li>
      <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

      <?php if (isset($_SESSION['admin'])) { ?>
        <li class="nav-item">
            <a href="admin/index.php" class="nav-link">Admin Panel</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>

<!-- Orders Section -->
<section class="account-wrapper">

  <!-- SIDEBAR -->
  <div class="account-sidebar">
      <div class="sidebar-profile">
          <div class="avatar-circle">
              <?php echo strtoupper(substr($_SESSION['user'],0,1)); ?>
          </div>
          <h3><?php echo htmlspecialchars($_SESSION['user']); ?></h3>
      </div>

      <ul class="sidebar-links">
          <li><a href="profile.php">Account</a></li>
          <li><a href="edit_profile.php">Edit Profile</a></li>
          <li><a href="change_password.php">Password</a></li>
          <li class="active"><a href="my_orders.php">Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
      </ul>
  </div>

  <!-- CONTENT -->
  <div class="account-content">
      <h2>My Orders</h2>

<?php
$orders = mysqli_query(
    $conn,
    "SELECT * FROM orders WHERE user='$user' ORDER BY created_at DESC"
);

if (!$orders || mysqli_num_rows($orders) == 0) {
    echo "<p class='empty-orders'>You have not placed any orders yet.</p>";
} else {
    while ($order = mysqli_fetch_assoc($orders)) {

        echo "<div class='profile-box full'>";
        echo "<div class='order-header'>";
        echo "<h3>Order #{$order['id']}</h3>";
        echo "<span class='order-date'>{$order['created_at']}</span>";
        echo "</div>";

        echo "<div class='order-total'>Total: ₹{$order['total_price']}</div>";

        $items = mysqli_query(
            $conn,
            "SELECT 
                oi.quantity,
                oi.price,
                p.name AS product_name
             FROM order_items oi
             JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = {$order['id']}"
        );

        echo "<div class='order-items'>";
        while ($item = mysqli_fetch_assoc($items)) {
            echo "<div class='order-item'>";
            echo "<span>{$item['product_name']}</span>";
            echo "<span>× {$item['quantity']}</span>";
            echo "<span>₹{$item['price']}</span>";
            echo "</div>";
        }
        echo "</div>";

        echo "</div>";
    }
}
?>

  </div>

</section>

</body>
</html>
