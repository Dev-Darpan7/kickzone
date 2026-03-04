<?php
session_start();
include "db.php";

if (!isset($_GET['order'])) {
    header("Location: index.php");
    exit;
}

$order_id = intval($_GET['order']);

/* Generate Fake Transaction ID */
$txn_id = "KZ" . strtoupper(uniqid());

/* Update Order */
mysqli_query($conn,
"UPDATE orders 
 SET payment_status='paid',
     status='confirmed',
     transaction_id='$txn_id'
 WHERE id=$order_id"
);

/* Redirect to final success page */
header("Location: order_success.php?order=".$order_id);
exit;
?>