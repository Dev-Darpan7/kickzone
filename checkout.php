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
?>

<!DOCTYPE html>
<html>
<head>
  <title>Checkout - KickZone</title>
  <link rel="stylesheet" href="shoe.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo"><h2>KickZone</h2></div>
    <ul class="nav-menu">
      <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
      <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
    </ul>
  </div>
</nav>

<!-- CHECKOUT UI -->
<section class="checkout-wrapper">
  <div class="checkout-card">

    <h2>Checkout</h2>

    <div class="checkout-total">
      Total Amount: <span>₹<?php echo $total; ?></span>
    </div>

    <form method="post" action="place_order.php" class="checkout-form">

      <!-- ADDRESS SECTION -->
      <h3>Delivery Details</h3>

      <input type="text" name="phone" placeholder="Phone"
        value="<?php echo $profile['phone'] ?? ''; ?>" required>

      <textarea name="address" placeholder="Full Address" required><?php echo $profile['address'] ?? ''; ?></textarea>

      <input type="text" name="city" placeholder="City"
        value="<?php echo $profile['city'] ?? ''; ?>" required>

      <input type="text" name="pincode" placeholder="Pincode"
        value="<?php echo $profile['pincode'] ?? ''; ?>" required>

      <!-- PAYMENT OPTIONS -->
      <h3>Payment Method</h3>

      <!-- COD -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="COD" checked>
        <div>
          <strong>Cash on Delivery</strong>
          <p>Pay when your order arrives</p>
        </div>
      </label>

      <!-- ONLINE -->
      <label class="payment-option">
        <input type="radio" name="payment_method" value="ONLINE">
        <div>
          <strong>Pay Online</strong>
          <p>UPI / Card / NetBanking (Demo)</p>
        </div>
      </label>

      <button class="checkout-btn">Continue</button>

    </form>

  </div>
</section>

</body>
</html>
