<?php
session_start();
include "db.php";

// Fetch 4 products for home page
$products = mysqli_query($conn, "SELECT * FROM products LIMIT 4");

include 'includes/header.php';
?>

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

<?php include 'includes/footer.php'; ?>