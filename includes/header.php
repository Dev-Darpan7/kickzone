<?php
if (!isset($_SESSION)) {
    session_start();
}
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
<a href="index.php" style="color: white; text-decoration: none;"><h2>KickZone</h2></a>
</div>

<?php if (isset($_SESSION["user"])) { ?>
<div class="nav-user" style="display: none;"> <!-- Hidden on desktop, handle if needed -->
<span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?></span>
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
<li class="nav-item"><a href="profile.php" class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?></a></li>
<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

<?php } else { ?>

<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
<li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>

<?php } ?>

</ul>

</div>
</nav>
