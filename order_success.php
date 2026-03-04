<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['order'])) {
    header("Location: index.php");
    exit;
}

$order_id = intval($_GET['order']);

/* Fetch Order */
$res = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
$order = mysqli_fetch_assoc($res);

if (!$order) {
    die("Order not found");
}

$user = $_SESSION['user'];
$payment_method = $order['payment_method'];
$payment_status = $order['payment_status'];
$total = $order['total_price'];
$txn_id = $order['transaction_id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success - KickZone</title>

<style>
body{
  margin:0;
  font-family: Arial, sans-serif;
  background:#e9edf3;
}

.overlay{
  height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
}

.box{
  width:1000px;
  height:560px;
  background:#fff;
  border-radius:18px;
  box-shadow:0 30px 80px rgba(0,0,0,0.25);
  display:flex;
  overflow:hidden;
}

/* LEFT PANEL */
.left{
  width:35%;
  background:linear-gradient(135deg,#2d6cdf,#2446b8);
  color:#fff;
  padding:40px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}

.price{
  font-size:30px;
  font-weight:bold;
  margin-top:10px;
}

/* RIGHT PANEL */
.right{
  width:65%;
  padding:40px;
  position:relative;
}

.success-icon{
  font-size:70px;
  color:#16a34a;
  margin-bottom:15px;
}

h2{
  margin-bottom:10px;
}

.details{
  margin-top:30px;
  font-size:16px;
}

.details p{
  margin:12px 0;
}

.label{
  font-weight:bold;
}

.buttons{
  margin-top:40px;
}

.btn{
  display:inline-block;
  padding:14px 22px;
  border-radius:8px;
  text-decoration:none;
  font-weight:bold;
  margin-right:10px;
}

.primary{
  background:#0a2540;
  color:#fff;
}

.primary:hover{
  background:#163d68;
}

.secondary{
  background:#e5e7eb;
  color:#000;
}

.secondary:hover{
  background:#d1d5db;
}
</style>
</head>

<body>

<div class="overlay">
<div class="box">

<div class="left">
  <div>
    <h2>KickZone</h2>
    <div>Amount Paid</div>
    <div class="price">₹<?php echo number_format($total,2); ?></div>
  </div>
  <div>Order Confirmed</div>
</div>

<div class="right">

<div class="success-icon">✔</div>

<h2>Order Placed Successfully!</h2>
<p>Thank you for shopping with <b>KickZone</b>, <?php echo htmlspecialchars($user); ?>.</p>

<div class="details">
  <p><span class="label">Order ID:</span> #<?php echo $order_id; ?></p>
  <p><span class="label">Payment Method:</span> <?php echo htmlspecialchars($payment_method); ?></p>
  <p><span class="label">Payment Status:</span> <?php echo ucfirst($payment_status); ?></p>

  <?php if($payment_method == "ONLINE" && $txn_id){ ?>
      <p><span class="label">Transaction ID:</span> <?php echo htmlspecialchars($txn_id); ?></p>
  <?php } ?>
</div>

<div class="buttons">
  <a href="my_orders.php" class="btn primary">View My Orders</a>
  <a href="products.php" class="btn secondary">Continue Shopping</a>
</div>

</div>
</div>
</div>

</body>
</html>