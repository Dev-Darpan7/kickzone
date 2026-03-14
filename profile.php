<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);
$res = mysqli_query($conn, "SELECT * FROM users WHERE name='$user'");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "User not found";
    exit;
}

include 'includes/header.php';
?>

<!-- PROFILE UI -->
<section class="account-wrapper" style="margin-top: 3rem; margin-bottom: 2rem;">

  <!-- LEFT SIDEBAR -->
  <div class="account-sidebar">
      <div class="sidebar-profile">
          <div class="avatar-circle">
              <?php echo strtoupper(substr($data['name'],0,1)); ?>
          </div>
          <h3><?php echo htmlspecialchars($data['name']); ?></h3>
      </div>

      <ul class="sidebar-links">
          <li class="active"><a href="profile.php">Account</a></li>
          <li><a href="edit_profile.php">Edit Profile</a></li>
          <li><a href="change_password.php">Password</a></li>
          <li><a href="my_orders.php">Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
      </ul>
  </div>

  <!-- RIGHT CONTENT -->
  <div class="account-content">
      <h2>Account Settings</h2>

      <div class="profile-grid">
          <div class="profile-box">
              <label>Name</label>
              <p><?php echo htmlspecialchars($data['name']); ?></p>
          </div>

          <div class="profile-box">
              <label>Email</label>
              <p><?php echo htmlspecialchars($data['email']); ?></p>
          </div>

          <div class="profile-box">
              <label>Phone</label>
              <p><?php echo $data['phone'] ?: 'Not set'; ?></p>
          </div>

          <div class="profile-box">
              <label>City</label>
              <p><?php echo $data['city'] ?: 'Not set'; ?></p>
          </div>

          <div class="profile-box full">
              <label>Address</label>
              <p><?php echo $data['address'] ?: 'Not set'; ?></p>
          </div>

          <div class="profile-box">
              <label>Pincode</label>
              <p><?php echo $data['pincode'] ?: 'Not set'; ?></p>
          </div>
      </div>

      <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
  </div>

</section>

<?php include 'includes/footer.php'; ?>
