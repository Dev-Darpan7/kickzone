<?php
session_start();
include "db.php";

include 'includes/header.php';
?>

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

<?php include 'includes/footer.php'; ?>