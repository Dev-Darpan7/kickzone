<?php
session_start();
include "db.php";

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$step    = 1;   // 1 = enter email, 2 = reset password
$message = "";
$msgType = "error";
$email_found = "";

/* ── STEP 1: Look up email ─────────────────────────── */
if (isset($_POST["find_account"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $res   = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($res);

    if ($user) {
        $step        = 2;
        $email_found = $email;
    } else {
        $message = "No account found with that email address.";
    }
}

/* ── STEP 2: Set new password ──────────────────────── */
if (isset($_POST["reset_password"])) {
    $email   = mysqli_real_escape_string($conn, trim($_POST["hidden_email"]));
    $newpass = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

    if (strlen($newpass) < 6) {
        $step        = 2;
        $email_found = $email;
        $message     = "Password must be at least 6 characters.";
    } elseif ($newpass !== $confirm) {
        $step        = 2;
        $email_found = $email;
        $message     = "Passwords do not match.";
    } else {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hash' WHERE email='$email'");
        $message = "Password reset successfully! You can now login.";
        $msgType = "success";
        $step    = 1;
    }
}

include 'includes/header.php';
?>

<style>
.forgot-wrap {
  max-width: 420px;
  margin: 6rem auto 3rem;
  background: #111;
  border: 1px solid #333;
  border-radius: 14px;
  padding: 2.5rem 2rem;
  text-align: center;
}
.forgot-wrap h2 {
  font-size: 1.7rem;
  margin-bottom: 0.5rem;
  color: #fff;
  letter-spacing: 1px;
}
.forgot-wrap p.sub {
  color: #888;
  font-size: 0.93rem;
  margin-bottom: 1.5rem;
}
.forgot-wrap input {
  width: 100%;
  padding: 12px;
  margin-bottom: 1rem;
  background: #000;
  border: 1px solid #333;
  color: #fff;
  border-radius: 8px;
  font-size: 1rem;
}
.forgot-wrap input:focus {
  outline: none;
  border-color: #007AFF;
}
.forgot-wrap button {
  width: 100%;
  padding: 12px;
  background: #007AFF;
  border: none;
  color: #fff;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: opacity 0.3s;
}
.forgot-wrap button:hover { opacity: 0.85; }
.forgot-wrap .back-link {
  display: block;
  margin-top: 1.1rem;
  color: #aaa;
  font-size: 0.9rem;
  text-decoration: none;
}
.forgot-wrap .back-link:hover { color: #007AFF; }
.fmsg {
  padding: 10px 14px;
  border-radius: 8px;
  margin-bottom: 1.2rem;
  font-size: 0.93rem;
  text-align: left;
}
.fmsg.error {
  background: rgba(255,80,80,0.1);
  border: 1px solid #ff5050;
  color: #ff7070;
}
.fmsg.success {
  background: rgba(0,255,136,0.1);
  border: 1px solid #00ff88;
  color: #00ff88;
}
.step-badge {
  display: inline-block;
  background: #007AFF22;
  color: #007AFF;
  font-size: 0.78rem;
  padding: 3px 12px;
  border-radius: 20px;
  border: 1px solid #007AFF55;
  margin-bottom: 1rem;
  letter-spacing: 1px;
  text-transform: uppercase;
}
</style>

<div class="forgot-wrap">

  <?php if ($message): ?>
    <div class="fmsg <?php echo $msgType; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($step === 1): ?>

    <div class="step-badge">Step 1 of 2</div>
    <h2>Forgot Password</h2>
    <p class="sub">Enter your registered email address to reset your password.</p>

    <form method="post">
      <input type="email" name="email" placeholder="Your Email Address" required>
      <button type="submit" name="find_account">Find My Account</button>
    </form>

    <a href="login.php" class="back-link">← Back to Login</a>

  <?php else: ?>

    <div class="step-badge">Step 2 of 2</div>
    <h2>Set New Password</h2>
    <p class="sub">Create a new password for <strong style="color:#fff"><?php echo htmlspecialchars($email_found); ?></strong>.</p>

    <form method="post">
      <input type="hidden" name="hidden_email" value="<?php echo htmlspecialchars($email_found); ?>">
      <input type="password" name="new_password" placeholder="New Password" required minlength="6">
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required minlength="6">
      <button type="submit" name="reset_password">Reset Password</button>
    </form>

    <a href="forgot_password.php" class="back-link">← Use a different email</a>

  <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
