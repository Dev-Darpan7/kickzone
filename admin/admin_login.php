<?php
session_start();
include "../db.php";

$error = "";

// Only process the form if it was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Safely get POST values to avoid undefined index warnings
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username && $password) {
        // Prepare query to prevent SQL injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin'] = $row['username']; // store username in session
                header("Location: index.php");
                exit;
            }
        }
    }

    $error = "Invalid admin credentials";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - KickZone</title>
    <link rel="stylesheet" href="login.css">
</head>
<body class="admin-login-body">

<div class="admin-login-container">
    
    <div class="admin-login-card">
        <h2>KickZone Admin</h2>
        <p class="subtitle">Sign in to manage dashboard</p>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>

        <form method="post" class="admin-login-form">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</div>

</body>
</html>