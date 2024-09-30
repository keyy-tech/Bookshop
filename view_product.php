<?php
global $conn;
include 'config.php'; // Ensure your database connection is established
session_start();

// Fetch products from the database
$sql = "SELECT id, name, information, price, stock FROM products"; // Include product ID for deletion
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Products - BookShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <style>
        .high-stock { color: green; }
        .medium-stock { color: orange; }
        .low-stock { color: red; }
        .icon { font-size: 1.5rem; } /* Adjust the font size here */
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<main>
    <div class="container">
        <h1 class="h4">Product List</h1>
        <a href="add_product.php" class="btn btn-outline-primary mb-3">Add New Product</a>

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
                <th>Actions</th>
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
                        <!--<td>
                            <a href='update_product.php?id=<?php /*= $row['id']; */?>' class='text-primary me-2' title='Update'>
                                <i class='fas fa-edit icon'></i>
                            </a>
                            <a href='#' class='text-danger' title='Delete' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='<?php /*= $row['id']; */?>' data-name='<?php /*= $row['name']; */?>'>
                                <i class='fas fa-trash-alt icon'></i>
                            </a>
                        </td>-->
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan='5' class='text-center'>No products found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product: <strong id="productName"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="delete_product.php" method="POST">
                    <input type="hidden" name="id" id="productId" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Event listener for delete button
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const productId = button.getAttribute('data-id'); // Extract product ID
        const productName = button.getAttribute('data-name'); // Extract product name

        // Set product name and ID in modal
        deleteModal.querySelector('#productName').textContent = productName;
        deleteModal.querySelector('#productId').value = productId;
    });
</script>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
