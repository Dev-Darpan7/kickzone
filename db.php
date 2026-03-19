<?php
$host = "sql206.infinityfree.com";
$user = "if0_41429261";
$pass = "jOgANcL1ZiCJc5";
$db   = "if0_41429261_kickzone";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>