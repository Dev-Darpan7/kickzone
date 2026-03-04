<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ================= HANDLE CART ================= */

if (isset($_POST['action'], $_POST['product_id'])) {
    $pid = intval($_POST['product_id']);

    if ($_POST['action'] === 'add') {
        $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + 1;

        $check = mysqli_query($conn, "SELECT * FROM cart WHERE user='$user' AND product_id=$pid");

        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user='$user' AND product_id=$pid");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user, product_id, quantity) VALUES ('$user', $pid, 1)");
        }
    }

    if ($_POST['action'] === 'remove') {
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]--;

            if ($_SESSION['cart'][$pid] <= 0) {
                unset($_SESSION['cart'][$pid]);
                mysqli_query($conn, "DELETE FROM cart WHERE user='$user' AND product_id=$pid");
            } else {
                mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE user='$user' AND product_id=$pid");
            }
        }
    }

    header("Location: cart.php");
    exit;
}

/* ================= FETCH CART ================= */

$cart_items = [];
$total_price = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(",", array_keys($_SESSION['cart']));
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

    while ($row = mysqli_fetch_assoc($res)) {
        $qty = $_SESSION['cart'][$row['id']];
        $row['quantity'] = $qty;
        $row['subtotal'] = $row['price'] * $qty;
        $total_price += $row['subtotal'];
        $cart_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart - KickZone</title>
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
      <li class="nav-item nav-link">Welcome, <?php echo $user; ?></li>
      <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
    </ul>
  </div>
</nav>

<section class="featured">
<h2>Your Cart</h2>

<div class="cart-container">

<?php if (empty($cart_items)) { ?>

  <p class="cart-empty">Your cart is empty.</p>
  <div class="cart-actions">
    <a href="products.php" class="cta-button">Continue Shopping</a>
  </div>

<?php } else { ?>

<table class="cart-table">

<tr>
  <th>Product</th>
  <th>Price</th>
  <th>Quantity</th>
  <th>Subtotal</th>
</tr>

<?php foreach ($cart_items as $item) { ?>

<tr>
  <td><?php echo $item['name']; ?></td>
  <td>₹<?php echo $item['price']; ?></td>

  <td class="cart-qty">

    <form method="post">
      <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
      <input type="hidden" name="action" value="remove">
      <button class="add-to-cart">−</button>
    </form>

    <?php echo $item['quantity']; ?>

    <form method="post">
      <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
      <input type="hidden" name="action" value="add">
      <button class="add-to-cart">+</button>
    </form>

  </td>

  <td>₹<?php echo $item['subtotal']; ?></td>
</tr>

<?php } ?>

<tr class="cart-total-row">
  <td colspan="3"><strong>Total</strong></td>
  <td><strong>₹<?php echo $total_price; ?></strong></td>
</tr>

</table>

<div class="cart-actions">
  <a href="products.php" class="cta-button">Continue Shopping</a>
  <a href="checkout.php" class="cta-button">Place Order</a>
</div>

<?php } ?>

</div>
</section>

</body>
</html>
