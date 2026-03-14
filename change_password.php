<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);
$msg = "";
$type = ""; // success / error

if (isset($_POST['change'])) {
    $old = $_POST['old'];
    $new = $_POST['new'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE name='$user'");
    $data = mysqli_fetch_assoc($res);

    if ($data && password_verify($old, $data['password'])) {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hash' WHERE name='$user'");
        $msg = "Password changed successfully";
        $type = "success";
    } else {
        $msg = "Wrong old password";
        $type = "error";
    }
}

include 'includes/header.php';
?>

<section class="account-wrapper" style="margin-top: 3rem; margin-bottom: 2rem;">

  <!-- SIDEBAR -->
  <div class="account-sidebar">
      <div class="sidebar-profile">
          <div class="avatar-circle">
              <?php echo strtoupper(substr($_SESSION['user'],0,1)); ?>
          </div>
          <h3><?php echo htmlspecialchars($_SESSION['user']); ?></h3>
      </div>

      <ul class="sidebar-links">
          <li><a href="profile.php">Account</a></li>
          <li><a href="edit_profile.php">Edit Profile</a></li>
          <li class="active"><a href="change_password.php">Password</a></li>
          <li><a href="my_orders.php">Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
      </ul>
  </div>

  <!-- CONTENT -->
  <div class="account-content">
      <h2>Change Password</h2>

      <?php if ($msg != "") { ?>
          <div class="msg <?php echo $type; ?>">
              <?php echo $msg; ?>
          </div>
      <?php } ?>

      <form method="post" class="account-form">

          <div class="profile-grid">

              <div class="profile-box full">
                  <label>Old Password</label>
                  <input type="password" name="old" required>
              </div>

              <div class="profile-box full">
                  <label>New Password</label>
                  <input type="password" name="new" required>
              </div>

          </div>

          <button class="edit-btn" name="change">Update Password</button>

      </form>
  </div>

</section>

<?php include 'includes/footer.php'; ?>
