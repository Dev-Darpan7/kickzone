<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h2 class="logo">KickZone</h2>

    <ul class="menu">

        <li class="<?php if($current_page == 'index.php') echo 'active'; ?>">
            <a href="index.php">
                <i class="fa fa-home"></i> Dashboard
            </a>
        </li>

        <li class="<?php if($current_page == 'products.php') echo 'active'; ?>">
            <a href="products.php">
                <i class="fa fa-box"></i> Products
            </a>
        </li>

        <li class="<?php if($current_page == 'orders.php') echo 'active'; ?>">
            <a href="orders.php">
                <i class="fa fa-shopping-cart"></i> Orders
            </a>
        </li>

        <li class="<?php if($current_page == 'analytics.php') echo 'active'; ?>">
            <a href="analytics.php">
                <i class="fa fa-chart-line"></i> Analytics
            </a>
        </li>

        <li>
            <a href="logout.php">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        </li>

    </ul>
</div>