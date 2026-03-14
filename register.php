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

include 'includes/header.php';
?>

  <!-- REGISTER SECTION -->
  <section class="auth-section" style="margin-top: 3rem; margin-bottom: 2rem;">
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

<?php include 'includes/footer.php'; ?>