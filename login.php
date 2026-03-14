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

include 'includes/header.php';
?>

<div class="auth-container" style="margin-top: 6rem; margin-bottom: 2rem;">
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

<?php include 'includes/footer.php'; ?>
