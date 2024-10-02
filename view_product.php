<?php
global $conn;
include 'config.php'; // Ensure your database connection is established
session_start();

// Automatically delete products with zero stock
$deleteQuery = "DELETE FROM products WHERE stock = 0";
$conn->query($deleteQuery);

// Fetch products from the database
$sql = "SELECT id, name, information, price, stock FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Products - BookShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .high-stock { color: green; }
        .medium-stock { color: orange; }
        .low-stock { color: red; }
        .icon { font-size: 1.5rem; }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<main>
    <div class="container">
        <h1 class="h4 mt-3">Product List</h1>
        <a href="add_product.php" class="btn btn-outline-primary mb-3 px-3 py-2 mt-2">Add New Product</a>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Information</th>
                <th>Unit Price (GHS)</th>
                <th>Stock</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Determine stock color class
                    $stockClass = ($row['stock'] < 20) ? 'low-stock' : (($row['stock'] < 50) ? 'medium-stock' : 'high-stock');
                    ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['information']; ?></td>
                        <td> ₵<?= $row['price']; ?></td>
                        <td><span class='<?= $stockClass; ?>'><?= $row['stock']; ?></span></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan='4' class='text-center'>No products found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
