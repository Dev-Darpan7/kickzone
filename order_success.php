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
<style>
/* Override default nav background for this page */
.navbar { position: relative; }
body{
  margin:0;
  font-family: Arial, sans-serif;
  background:#000;
  padding-top: 0;
  color:#fff;
}

.overlay{
  height:calc(100vh - 80px); /* Adjust for navbar */
  display:flex;
  align-items:center;
  justify-content:center;
}

.box{
  width:1000px;
  height:560px;
  background:#111;
  border-radius:20px;
  box-shadow:0 20px 60px rgba(0,0,0,0.8);
  display:flex;
  overflow:hidden;
  border: 1px solid #333;
}

/* LEFT PANEL */
.left{
  width:35%;
  background:linear-gradient(135deg,#0a1128,#162447);
  color:#fff;
  padding:50px 40px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  border-right: 1px solid #222;
}

.left h2{
  font-size:28px;
  margin-bottom:25px;
  letter-spacing:1px;
}

.left div > div:nth-child(2){
  color:#aaa;
  font-size:15px;
  margin-bottom:5px;
  text-transform:uppercase;
  letter-spacing:1px;
}

.price{
  font-size:38px;
  font-weight:bold;
  color:#00ff88;
}

.left > div:last-child{
  color:#888;
  font-size:14px;
  display:flex;
  align-items:center;
  gap:8px;
}

.left > div:last-child::before{
  content:'🎉';
  font-size:18px;
}

/* RIGHT PANEL */
.right{
  width:65%;
  padding:50px;
  position:relative;
  display:flex;
  flex-direction:column;
  justify-content:center;
}

.success-icon{
  font-size:70px;
  color:#00ff88;
  margin-bottom:20px;
  text-shadow: 0 0 20px rgba(0, 255, 136, 0.4);
}

h2{
  margin-bottom:15px;
  font-size:32px;
  letter-spacing:1px;
}

.right > p {
  color: #aaa;
  font-size: 16px;
  line-height: 1.5;
}

.details{
  margin-top:40px;
  font-size:15px;
  background: #151515;
  padding: 25px;
  border-radius: 12px;
  border: 1px solid #222;
}

.details p{
  margin:15px 0;
  display:flex;
  justify-content:space-between;
  border-bottom: 1px dashed #333;
  padding-bottom: 15px;
}

.details p:last-child {
  border-bottom: none;
  padding-bottom: 0;
  margin-bottom: 0;
}

.label{
  color: #888;
  font-weight:600;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 13px;
}

.details span:last-child {
  font-weight: bold;
  color: #fff;
}

.buttons{
  margin-top:40px;
  display:flex;
  gap:15px;
}

.btn{
  display:inline-block;
  padding:16px 28px;
  border-radius:10px;
  text-decoration:none;
  font-weight:bold;
  font-size:15px;
  text-transform:uppercase;
  letter-spacing:1px;
  transition:all 0.3s;
  text-align:center;
  flex:1;
}

.primary{
  background:#007AFF;
  color:#fff;
  box-shadow:0 8px 20px rgba(0,122,255,0.3);
}

.primary:hover{
  background:#005bb5;
  transform:translateY(-2px);
}

.secondary{
  background:#222;
  color:#fff;
  border: 1px solid #444;
}

.secondary:hover{
  background:#333;
  transform:translateY(-2px);
}
</style>
<?php include 'includes/header.php'; ?>

<div class="overlay" style="margin-top: 4rem; margin-bottom: 2rem;">
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

<?php include 'includes/footer.php'; ?>