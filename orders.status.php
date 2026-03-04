<?php
session_start();
include "db.php";

/* ===== LOGIN CHECK ===== */
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* ===== CART CHECK ===== */
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

/* ===== GET USER ===== */
$user = mysqli_real_escape_string($conn, $_SESSION['user']);

/* get user id */
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE username='$user'");
$user_data  = mysqli_fetch_assoc($user_query);
$user_id    = $user_data['id'];

/* ===== GET FORM DATA ===== */
$phone   = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$city    = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
$pincode = mysqli_real_escape_string($conn, $_POST['pincode'] ?? '');

$payment_method = $_POST['payment_method'] ?? 'COD';
$payment_status = ($payment_method == 'ONLINE') ? 'pending' : 'success';

$total_price = 0;

/* ===== CALCULATE TOTAL ===== */
$ids = implode(",", array_keys($_SESSION['cart']));
$res = mysqli_query($conn, "SELECT id, price FROM products WHERE id IN ($ids)");

while ($row = mysqli_fetch_assoc($res)) {
    $qty = $_SESSION['cart'][$row['id']];
    $total_price += $row['price'] * $qty;
}

/* ===== INSERT ORDER ===== */
mysqli_query(
    $conn,
    "INSERT INTO orders 
    (user_id, user, phone, address, city, pincode, total_price, payment_method, payment_status, created_at)
    VALUES 
    ($user_id, '$user', '$phone', '$address', '$city', '$pincode', $total_price, '$payment_method', '$payment_status', NOW())"
);

$order_id = mysqli_insert_id($conn);

/* ===== INSERT ORDER ITEMS ===== */
$res = mysqli_query($conn, "SELECT id, price FROM products WHERE id IN ($ids)");

while ($row = mysqli_fetch_assoc($res)) {

    $pid   = $row['id'];
    $price = $row['price'];
    $qty   = $_SESSION['cart'][$pid];

    mysqli_query(
        $conn,
        "INSERT INTO order_items (order_id, product_id, price, quantity)
         VALUES ($order_id, $pid, $price, $qty)"
    );
}

/* ===== CLEAR CART ===== */
mysqli_query($conn, "DELETE FROM cart WHERE user='$user'");
unset($_SESSION['cart']);

/* ===== REDIRECT ===== */
if ($payment_method == "ONLINE") {

    $_SESSION['last_order_id'] = $order_id;
    header("Location: pay.php");

} else {

    $_SESSION['last_order_id'] = $order_id;
    header("Location: order_success.php");

}

exit;
?>