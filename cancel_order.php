<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['order_id'])) {
    header("Location: my_orders.php");
    exit;
}

$user     = mysqli_real_escape_string($conn, $_SESSION['user']);
$order_id = intval($_POST['order_id']);

// Fetch the order — must belong to this user and be Pending
$res   = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id AND user='$user'");
$order = mysqli_fetch_assoc($res);

if (!$order) {
    header("Location: my_orders.php?msg=not_found");
    exit;
}

if ($order['status'] !== 'Pending') {
    header("Location: my_orders.php?msg=cannot_cancel");
    exit;
}

// Cancel it
mysqli_query($conn, "UPDATE orders SET status='Cancelled' WHERE id=$order_id AND user='$user'");

header("Location: my_orders.php?msg=cancelled");
exit;
?>
