<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = mysqli_real_escape_string($conn, $_SESSION['user']);

if (isset($_POST['update'])) {
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city    = mysqli_real_escape_string($conn, $_POST['city']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

    mysqli_query($conn, "UPDATE users SET 
        phone='$phone',
        address='$address',
        city='$city',
        pincode='$pincode'
        WHERE name='$user'");

    header("Location: profile.php?updated=1");
    exit;
}

$res = mysqli_query($conn, "SELECT * FROM users WHERE name='$user'");
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile - KickZone</title>
<link rel="stylesheet" href="shoe.css">
</head>
<body>

<section class="account-wrapper">

  <!-- SIDEBAR (same as profile.php) -->
  <div class="account-sidebar">
      <div class="sidebar-profile">
          <div class="avatar-circle">
              <?php echo strtoupper(substr($data['name'],0,1)); ?>
          </div>
          <h3><?php echo htmlspecialchars($data['name']); ?></h3>
      </div>

      <ul class="sidebar-links">
          <li><a href="profile.php">Account</a></li>
          <li class="active"><a href="edit_profile.php">Edit Profile</a></li>
          <li><a href="change_password.php">Password</a></li>
          <li><a href="my_orders.php">Orders</a></li>
          <li><a href="logout.php">Logout</a></li>
      </ul>
  </div>

  <!-- RIGHT CONTENT -->
  <div class="account-content">
      <h2>Update Profile</h2>

      <form method="post" class="account-form">

          <div class="profile-grid">

              <div class="profile-box">
                  <label>Phone</label>
                  <input type="text" name="phone"
                      value="<?php echo htmlspecialchars($data['phone']); ?>" required>
              </div>

              <div class="profile-box">
                  <label>City</label>
                  <input type="text" name="city"
                      value="<?php echo htmlspecialchars($data['city']); ?>" required>
              </div>

              <div class="profile-box full">
                  <label>Address</label>
                  <textarea name="address" required><?php echo htmlspecialchars($data['address']); ?></textarea>
              </div>

              <div class="profile-box">
                  <label>Pincode</label>
                  <input type="text" name="pincode"
                      value="<?php echo htmlspecialchars($data['pincode']); ?>" required>
              </div>

          </div>

          <button class="edit-btn" name="update">Save Changes</button>

      </form>
  </div>

</section>

</body>
</html>
