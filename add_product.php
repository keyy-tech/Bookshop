<?php
global $conn;
include 'config.php'; // Ensure your database connection is established
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize inputs
    $product_name = trim($_POST['product_name']);
    $information = trim($_POST['info']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['quantity']); // Change this to stock for clarity

    // Initialize an error array
    $errors = [];

    // Validate inputs
    if (empty($product_name)) {
        $errors[] = 'Product name is required.';
    }
    if (!is_numeric($price) || $price <= 0) {
        $errors[] = 'Please provide a valid price.';
    }
    if (!is_numeric($stock) || $stock < 0) {
        $errors[] = 'Please provide a valid stock amount.';
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, information, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $product_name, $information, $price, $stock);

        if ($stmt->execute()) {
            // Redirect to the view products page or show a success message
            $_SESSION['success_message'] = 'Product added successfully!';
            header('Location: view_product.php');
            exit();
        } else {
            $errors[] = 'Database error: Unable to add product.';
        }

        $stmt->close();
    }

    // Store errors in session for display
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product - BookShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>

<main>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-1 border-bottom pt-1">
            <h1 class="h4">Add Product</h1>
        </div>

        <!-- Display any error messages -->
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Product Form -->
        <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4 mt-4" novalidate>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingProductName" name="product_name" placeholder="Product Name" required>
                <label for="floatingProductName">Product Name</label>
                <div class="invalid-feedback">
                    Please provide a correct product name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInfo" name="info" placeholder="Information">
                <label for="floatingInfo">Information</label>
                <div class="invalid-feedback">
                    Please provide correct information.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingPrice" name="price" placeholder="Price in GHS" required>
                <label for="floatingPrice">Unit Price (GHS)</label>
                <div class="invalid-feedback">
                    Please provide a correct price.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingQuantity" name="quantity" placeholder="Stock" required>
                <label for="floatingQuantity">Stock</label>
                <div class="invalid-feedback">
                    Please provide a correct stock amount.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Product</button>
            <a href="view_products.php" class="btn btn-outline-secondary mt-1 ms-3">View Products</a>
        </form>
    </div>
</main>

<script>
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

</body>
</html>
