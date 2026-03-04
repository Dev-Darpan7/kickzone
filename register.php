<?php
session_start();
include "db.php";

$message = "";

if (isset($_POST["register"])) {
    $name  = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pass  = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $message = "Email already registered";
    } else {
        mysqli_query($conn,
            "INSERT INTO users (name, email, password)
             VALUES ('$name', '$email', '$pass')"
        );
        
        // Auto-login after registration
        $_SESSION["user"] = $name;
        $_SESSION["email"] = $email;
        
        // Redirect to products page (change to your actual products page filename)
        header("Location: products.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - KickZone</title>
  <link rel="stylesheet" href="shoe.css">
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo"><h2>KickZone</h2></div>
      <ul class="nav-menu">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>
        <?php if (isset($_SESSION["user"])) { ?>
          <li class="nav-item nav-link">Welcome, <?php echo $_SESSION["user"]; ?></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        <?php } else { ?>
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
        <?php } ?>
      </ul>
    </div>
  </nav>

  <!-- REGISTER SECTION -->
  <section class="auth-section">
    <div class="auth-container">
      <h2>Register</h2>

      <?php if ($message) { ?>
        <div class="auth-message"><?php echo $message; ?></div>
      <?php } ?>

      <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
      </form>

      <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </section>

  <script src="shoe.js"></script>
</body>
</html>