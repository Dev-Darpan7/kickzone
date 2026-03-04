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

/* get user id from users table */
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE name='$user'");
$user_data  = mysqli_fetch_assoc($user_query);
$user_id    = $user_data['id'];

/* ===== GET FORM DATA ===== */
$phone   = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$city    = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
$pincode = mysqli_real_escape_string($conn, $_POST['pincode'] ?? '');

$payment_method = $_POST['payment_method'] ?? 'COD';

/* FIXED PAYMENT STATUS */
if ($payment_method == 'ONLINE') {
    $payment_status = 'pending';
} else {
    $payment_status = 'cod';
}

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
    (user_id, user, phone, address, city, pincode, total_price, status, payment_method, payment_status, created_at)
    VALUES 
    ($user_id, '$user', '$phone', '$address', '$city', '$pincode', $total_price, 'pending', '$payment_method', '$payment_status', NOW())"
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
$_SESSION['last_order_id'] = $order_id;

if ($payment_method == "ONLINE") {
    header("Location: pay.php");
} else {
    header("Location: order_success.php?order=".$order_id);
}

exit;
?>