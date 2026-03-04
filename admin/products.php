<?php
session_start();
include "../db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Add / Edit / Delete
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {

    $action = $_POST['action'];
    $name   = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price  = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    $name = mysqli_real_escape_string($conn, $name);

    // ADD
    if ($action === 'add' && $name !== '' && $price > 0) {
        mysqli_query($conn, 
            "INSERT INTO products (name, price) 
            VALUES ('$name', $price)"
        );
    }

    // EDIT
    if ($action === 'edit' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        if ($name !== '' && $price > 0) {
            mysqli_query($conn, 
                "UPDATE products 
                SET name='$name', price=$price 
                WHERE id=$id"
            );
        }
    }

    // DELETE
    if ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    }
}

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Products - KickZone</title>
<link rel="stylesheet" href="admin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">

    <?php include "sidebar.php"; ?>

    <div class="main-content">

        <div class="topbar">
            <h2>Manage Products</h2>
            <div class="admin-info">
    <i class="fa fa-user-circle"></i>
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></span>
</div>
        </div>

        <!-- ADD PRODUCT -->
        <div class="form-section">
            <h3>Add New Product</h3>
            <form method="post" class="product-form">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="number" step="0.01" name="price" placeholder="Price" required>
                <button type="submit" class="admin-btn">
                    <i class="fa fa-plus"></i> Add Product
                </button>
            </form>
        </div>

        <!-- PRODUCT TABLE -->
        <div class="table-section">
            <h3>Existing Products</h3>

            <table>
                <thead>
                    <tr>
                        <!-- ID column removed -->
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php while($p = mysqli_fetch_assoc($products)) { 
                    $pid    = $p['id'];
                    $pname  = $p['name'];
                    $pprice = $p['price'];
                ?>

                <tr>
                    <td><?php echo htmlspecialchars($pname); ?></td>
                    <td>₹<?php echo number_format($pprice, 2); ?></td>

                    <td>
                        <form method="post" style="display:flex; gap:8px; align-items:center;">
                            
                            <input type="hidden" name="id" value="<?php echo $pid; ?>">

                            <input type="text" name="name"
                                value="<?php echo htmlspecialchars($pname); ?>" required>

                            <input type="number" step="0.01" name="price"
                                value="<?php echo $pprice; ?>" required>

                            <button type="submit" name="action" value="edit"
                                class="admin-btn small-btn">
                                <i class="fa fa-save"></i> Save
                            </button>

                            <button type="submit" name="action" value="delete"
                                class="admin-btn danger-btn small-btn"
                                onclick="return confirm('Delete this product?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>

                        </form>
                    </td>
                </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>