<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user = $_SESSION['user'];

/* ===== Get user profile for autofill ===== */
$resUser = mysqli_query($conn, "SELECT * FROM users WHERE name='$user'");
$profile = mysqli_fetch_assoc($resUser);

/* ===== Calculate total ===== */
$total = 0;
$ids = implode(",", array_keys($_SESSION['cart']));
$res = mysqli_query($conn, "SELECT id, price FROM products WHERE id IN ($ids)");

while ($row = mysqli_fetch_assoc($res)) {
    $qty = $_SESSION['cart'][$row['id']];
    $total += $row['price'] * $qty;
}

include 'includes/header.php';
?>

<style>
/* PREMIUM CHECKOUT DESIGN */
body {
  background: #000;
  color: #fff;
}
.checkout-wrapper {
  min-height: calc(100vh - 80px);
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 60px 20px;
}

.checkout-split {
  display: flex;
  gap: 30px;
  width: 100%;
  max-width: 1000px;
}

.checkout-left, .checkout-right {
  background: #111;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.8);
  border: 1px solid #333;
}

.checkout-left {
  flex: 1.5;
}

.checkout-right {
  flex: 1;
  position: sticky;
  top: 100px;
  height: fit-content;
}

.checkout-split h2 {
  font-size: 26px;
  margin-bottom: 25px;
  color: #fff;
  letter-spacing: 1px;
}

.checkout-total {
  background: #151515;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  font-size: 16px;
  color: #aaa;
  margin-bottom: 25px;
  border: 1px solid #222;
}

.checkout-total span {
  display: block;
  font-size: 32px;
  font-weight: bold;
  color: #00ff88;
  margin-top: 10px;
}

.checkout-form input[type="text"],
.checkout-form textarea {
  width: 100%;
  padding: 16px;
  background: #000;
  border: 1px solid #333;
  color: #fff;
  border-radius: 10px;
  margin-bottom: 20px;
  font-family: inherit;
  font-size: 15px;
  transition: all 0.3s;
  box-sizing: border-box;
}

.checkout-form textarea {
  resize: vertical;
  min-height: 120px;
}

.checkout-form input:focus,
.checkout-form textarea:focus {
  border-color: #007AFF;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0,122,255,0.2);
}

.payment-title {
  font-size: 16px;
  color: #888;
  margin-bottom: 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 1px solid #222;
  padding-bottom: 10px;
}

.payment-option {
  display: flex;
  align-items: center;
  background: #000;
  padding: 16px;
  border-radius: 10px;
  border: 1px solid #333;
  margin-bottom: 12px;
  cursor: pointer;
  transition: all 0.3s;
}

.payment-option:hover {
  background: #1a1a1a;
  border-color: #555;
}

.payment-option input[type="radio"] {
  width: 20px;
  height: 20px;
  margin-right: 15px;
  accent-color: #007AFF;
}

.payment-option div strong {
  display: block;
  font-size: 15px;
  color: #fff;
  margin-bottom: 4px;
}

.payment-option div p {
  font-size: 13px;
  color: #888;
  margin: 0;
}

.checkout-btn {
  width: 100%;
  padding: 18px;
  background: #007AFF;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: bold;
  margin-top: 20px;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s;
}

.checkout-btn:hover {
  background: #005bb5;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0,122,255,0.3);
}

@media (max-width: 800px) {
  .checkout-split {
    flex-direction: column;
  }
}
</style>

<!-- CHECKOUT UI -->
<section class="checkout-wrapper">
  <form method="post" action="place_order.php" class="checkout-split">
    
    <!-- LEFT SIDE: Delivery Details -->
    <div class="checkout-left">
      <h2>Delivery Details</h2>
      
      <div class="checkout-form">
        <input type="text" name="name" placeholder="Full Name"
          value="<?php echo htmlspecialchars($profile['name'] ?? $user); ?>" required>

        <input type="text" name="phone" placeholder="Phone"
          value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>" required>

        <textarea name="address" placeholder="Full Address" required><?php echo htmlspecialchars($profile['address'] ?? ''); ?></textarea>

        <input type="text" name="city" placeholder="City"
          value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>" required>

        <input type="text" name="pincode" placeholder="Pincode"
          value="<?php echo htmlspecialchars($profile['pincode'] ?? ''); ?>" required>
      </div>
    </div>

    <!-- RIGHT SIDE: Order Summary & Payment -->
    <div class="checkout-right">
      <h2>Order Summary</h2>
      
      <div class="checkout-total">
        Total Amount <span>₹<?php echo $total; ?></span>
      </div>

      <div class="payment-title">Payment Method</div>

      <!-- COD -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="COD" required>
        <div>
          <strong>Cash on Delivery</strong>
          <p>Pay when your order arrives</p>
        </div>
      </label>

      <!-- ONLINE -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="ONLINE" required>
        <div>
          <strong>Pay Online</strong>
          <p>UPI / Card / NetBanking</p>
        </div>
      </label>

      <button class="checkout-btn">Continue</button>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>
