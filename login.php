<?php
session_start();
include "db.php";

$message = "";

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass  = $_POST["password"];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($pass, $user["password"])) {
        $_SESSION["user"] = $user["name"];
        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - KickZone</title>
  <link rel="stylesheet" href="shoe.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo"><h2>KickZone</h2></div>
    <ul class="nav-menu">
      <li><a href="index.php" class="nav-link">Home</a></li>
      <li><a href="products.php" class="nav-link">Products</a></li>
      <li><a href="register.php" class="nav-link">Register</a></li>
    </ul>
  </div>
</nav>

<div class="auth-container">
  <h2>Login</h2>

  <?php if ($message) { ?>
    <div class="auth-message"><?php echo $message; ?></div>
  <?php } ?>

  <form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>

  <a href="register.php">Create new account</a>
</div>

</body>
</html>
