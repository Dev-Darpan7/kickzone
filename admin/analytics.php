<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

/* Monthly revenue for current year */
$monthly = mysqli_query(
    $conn,
    "SELECT 
        MONTH(created_at) AS month_num,
        MONTHNAME(created_at) AS month_name,
        SUM(total_price) AS total
     FROM orders
     WHERE YEAR(created_at) = YEAR(CURDATE())
     GROUP BY MONTH(created_at), MONTHNAME(created_at)
     ORDER BY MONTH(created_at)"
);

$months = [];
$revenues = [];

while ($row = mysqli_fetch_assoc($monthly)) {
    $months[] = $row['month_name'];
    $revenues[] = (float)$row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Analytics - KickZone</title>
<link rel="stylesheet" href="admin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <?php include "sidebar.php"; ?>

    <!-- MAIN -->
    <div class="main-content">

        <div class="topbar">
            <h2>Analytics Overview</h2>
            <div>Admin: <?php echo htmlspecialchars($_SESSION['admin']); ?></div>
        </div>

        <div class="card">
            <h3>Monthly Revenue (<?php echo date('Y'); ?>)</h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

    </div>
</div>

<script>
const ctx = document.getElementById('revenueChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Revenue (₹)',
            data: <?php echo json_encode($revenues); ?>,
            borderWidth: 3,
            tension: 0.4,
            fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>