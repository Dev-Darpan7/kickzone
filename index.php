<?php
session_start();
include "db.php";

// Fetch 4 products for home page
$products = mysqli_query($conn, "SELECT * FROM products LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>KickZone - Premium Shoes</title>
<link rel="stylesheet" href="shoe.css" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
<div class="nav-container">

<div class="nav-logo">
<h2>KickZone</h2>
</div>

<?php if (isset($_SESSION["user"])) { ?>
<div class="nav-user">
<span class="nav-link">Welcome, <?php echo $_SESSION["user"]; ?></span>
<a href="profile.php" class="nav-link">Profile</a>
</div>
<?php } ?>

<div class="hamburger" onclick="toggleMenu()">
<span></span>
<span></span>
<span></span>
</div>

<ul class="nav-menu" id="navMenu">

<li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
<li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>

<?php if (isset($_SESSION['admin'])) { ?>
<li class="nav-item">
<a href="admin/index.php" class="nav-link">Admin Panel</a>
</li>
<?php } ?>

<?php if (isset($_SESSION["user"])) { ?>

<li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
<li class="nav-item"><a href="my_orders.php" class="nav-link">Orders</a></li>
<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

<?php } else { ?>

<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
<li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>

<?php } ?>

</ul>

</div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
<div class="hero-content">
<h1>Step Into Style</h1>
<p>Discover the latest collection of premium footwear</p>

<?php if (isset($_SESSION["user"])) { ?>
<a href="products.php" class="cta-button">Shop Now</a>
<?php } else { ?>
<a href="login.php" class="cta-button">Login to Shop</a>
<?php } ?>

</div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="featured">
<h2>Featured Kicks</h2>
<div class="products-grid">
<?php while ($row = mysqli_fetch_assoc($products)) { ?>
<div class="product-card">
<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
<div class="product-info">
<h3><?php echo $row['name']; ?></h3>
<p class="product-price">₹<?php echo $row['price']; ?></p>

<?php if (isset($_SESSION["user"])) { ?>
<form method="post" action="cart.php">
<input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
<input type="hidden" name="action" value="add">
<button type="submit" class="add-to-cart">Add to Cart</button>
</form>
<?php } else { ?>
<a href="login.php" class="add-to-cart">Login to Buy</a>
<?php } ?>

</div>
</div>
<?php } ?>
</div>
</section>

<!-- FOOTER -->
<footer class="footer">
<div class="footer-container">

<div class="footer-section">
<h3>KickZone</h3>
<p>Premium footwear for style and comfort. Walk with confidence.</p>
</div>

<div class="footer-section">
<h4>Quick Links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="register.php">Register</a></li>
</ul>
</div>

<div class="footer-section">
<h4>Contact</h4>
<p>Email: support@kickzone.com</p>
<p>Phone: +91 98765 43210</p>
<p>Location: Mumbai, India</p>
</div>

</div>

<div class="footer-bottom">
<p>© <?php echo date("Y"); ?> KickZone. All rights reserved.</p>
</div>
</footer>
<script>
function toggleMenu(){

const menu = document.querySelector(".nav-menu");
const burger = document.querySelector(".hamburger");

menu.classList.toggle("active");
burger.classList.toggle("active");

}
</script>

</body>
</html>