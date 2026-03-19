<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];   // using username (STRING)

include 'includes/header.php';
?>

<style>
/* ── Confirm modal for Light Theme ── */
.modal-overlay {
  display: none;
  position: fixed; inset: 0;
  background: rgba(0,0,0,0.5);
  z-index: 9999;
  justify-content: center;
  align-items: center;
}
.modal-overlay.active { display: flex; }
.modal-box {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 2rem;
  max-width: 320px;
  width: 90%;
  text-align: center;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  color: #333;
}
.modal-box h3 { margin-bottom: 0.6rem; font-size: 1.2rem; color: #111; }
.modal-box p  { color: #666; font-size: 0.9rem; margin-bottom: 1.5rem; }
.modal-actions { display: flex; gap: 10px; justify-content: center; }
.modal-confirm {
  background: #ff4d4d; color: #fff; border: none;
  padding: 8px 18px; border-radius: 6px;
  font-weight: 600; cursor: pointer;
}
.modal-dismiss {
  background: #eee; color: #555; border: 1px solid #ccc;
  padding: 8px 18px; border-radius: 6px;
  font-weight: 600; cursor: pointer;
}
</style>

<!-- Cancel Confirm Modal -->
<div class="modal-overlay" id="cancelModal">
  <div class="modal-box">
    <h3>Cancel Order?</h3>
    <p>This action cannot be undone.</p>
    <div class="modal-actions">
      <form method="post" action="cancel_order.php">
        <input type="hidden" name="order_id" id="modalOrderId">
        <button type="submit" class="modal-confirm">Yes, Cancel</button>
      </form>
      <button class="modal-dismiss" onclick="closeModal()">Close</button>
    </div>
  </div>
</div>

<!-- Orders Section -->
<section class="account-wrapper" style="margin-top: 3rem; margin-bottom: 2rem;">

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
      if (isset($_GET['msg'])) {
          if ($_GET['msg'] == 'cancelled') echo "<p style='color:#0a7d35; background:#e7f8ee; padding:10px; border-radius:6px; margin-bottom:15px;'>Order cancelled successfully.</p>";
          if ($_GET['msg'] == 'cannot_cancel') echo "<p style='color:#b42318; background:#fdeaea; padding:10px; border-radius:6px; margin-bottom:15px;'>This order cannot be cancelled starting process.</p>";
      }
      ?>

<?php
$orders = mysqli_query(
    $conn,
    "SELECT * FROM orders WHERE user='$user' ORDER BY created_at DESC"
);

if (!$orders || mysqli_num_rows($orders) == 0) {
    echo "<p class='empty-orders'>You have not placed any orders yet.</p>";
} else {
    while ($order = mysqli_fetch_assoc($orders)) {

        $status = (!empty($order['status'])) ? $order['status'] : 'Pending';
        $status_color = ($status == 'Completed') ? '#0a7d35' : (($status == 'Cancelled') ? '#ff4d4d' : '#f59e0b');

        echo "<div class='profile-box full'>";
        echo "<div class='order-header' style='display:flex; justify-content:space-between; align-items:flex-start;'>";
        
        echo "<div>";
        echo "<h3>Order #{$order['id']} <span style='font-size:13px; color:$status_color; font-weight:bold; margin-left:10px;'>$status</span></h3>";
        echo "</div>";

        echo "<div style='text-align:right;'>";
        echo "<span class='order-date'>{$order['created_at']}</span>";
        if ($status === 'Pending') {
            echo "<br><button onclick='openModal({$order['id']})' style='margin-top:5px; background:none; border:none; color:#ff4d4d; font-weight:bold; font-size:12px; cursor:pointer; text-decoration:underline;'>Cancel Order</button>";
        }
        echo "</div>";
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

<script>
function openModal(orderId) {
    document.getElementById('modalOrderId').value = orderId;
    document.getElementById('cancelModal').classList.add('active');
}
function closeModal() {
    document.getElementById('cancelModal').classList.remove('active');
}
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php include 'includes/footer.php'; ?>
