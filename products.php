<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products - KickZone</title>
  <link rel="stylesheet" href="shoe.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo"><h2>KickZone</h2></div>

    <!-- Hamburger -->
   <div class="hamburger" id="hamburger">
  <span></span>
  <span></span>
  <span></span>
</div>
    <ul class="nav-menu" id="nav-menu">
      <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>

      <?php if (isset($_SESSION['admin'])) { ?>
        <li class="nav-item">
          <a href="admin/index.php" class="nav-link">Admin Panel</a>
        </li>
      <?php } ?>

      <?php if (isset($_SESSION['user'])) { ?>

        <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
        <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>

        <li class="nav-item"><a href="my_orders.php" class="nav-link">Orders</a></li>
        <li class="nav-item nav-link">Welcome, <?php echo $_SESSION['user']; ?></li>
        <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

      <?php } else { ?>
        <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
      <?php } ?>
    </ul>
  </div>
</nav>

<!-- Products Section -->
<section class="featured">
  <h2>Our Shoes</h2>

  <div class="products-grid">
    <?php
    $res = mysqli_query($conn, "SELECT * FROM products");
    while ($product = mysqli_fetch_assoc($res)) {
    ?>
      <div class="product-card">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">

        <div class="product-info">
          <h3><?php echo $product['name']; ?></h3>
          <p class="product-price">₹<?php echo $product['price']; ?></p>

          <!-- Add to Cart -->
          <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="action" value="add">
            <button type="submit" class="add-to-cart">Add to Cart</button>
          </form>

        </div>
      </div>
    <?php } ?>
  </div>
</section>

<script>
const hamburger = document.getElementById("hamburger");
const navMenu = document.getElementById("nav-menu");

hamburger.onclick = function(){
  hamburger.classList.toggle("active");
  navMenu.classList.toggle("active");
};
</script> 

</body>
</html>