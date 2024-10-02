<?php
global $conn;
include 'config.php'; // Ensure your database connection is established
session_start();

// Fetch products from the database for the dropdown
$productQuery = "SELECT id, name, price FROM products";
$productResult = $conn->query($productQuery);

// Initialize total sales amount
$totalSalesAmount = 0;

// Handle the form submission for adding sales
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $products = $_POST['product_id'];
    $quantities = $_POST['quantity_sold'];

    foreach ($products as $index => $product_id) {
        $quantity_sold = $quantities[$index];

        // Fetch the product's price based on the selected product
        $priceQuery = "SELECT price FROM products WHERE id = ?";
        $stmt = $conn->prepare($priceQuery);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $price_per_unit = $product['price'];
        $total_price = $price_per_unit * $quantity_sold;

        // Insert the sale into the `sales` table
        $insertSaleQuery = "INSERT INTO sales (product_id, quantity, total, sale_date) 
                            VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($insertSaleQuery);
        $stmt->bind_param("iid", $product_id, $quantity_sold, $total_price);
        $stmt->execute();

        // Accumulate the total sales amount
        $totalSalesAmount += $total_price;
    }

    $_SESSION['success_message'] = 'Sale(s) added successfully!';
    header('Location: add_sales.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Daily Sale - BookShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .total-sales-card {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #9dabba;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .total-sales-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .total-sales-amount {
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<main>
    <div class="container">
        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Form for adding sales -->
        <form action="" method="post" class="form-floating needs-validation mt-3" novalidate>
            <div id="products-container">
                <div class="row product-row mb-3">
                    <div class="col-md-5">
                        <div class="form-floating">
                            <select class="form-control product-select" name="product_id[]" required onchange="updatePrice(this)">
                                <option value="" disabled selected>Select Product</option>
                                <?php while ($product = $productResult->fetch_assoc()): ?>
                                    <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>">
                                        <?php echo $product['name']; ?> (GHS <?php echo $product['price']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label for="product_id[]">Product</label>
                            <div class="invalid-feedback">Please select a product.</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" class="form-control quantity-input" name="quantity_sold[]" placeholder="Quantity" required min="1" onchange="updatePrice(this)">
                            <label for="quantity_sold[]">Quantity Sold</label>
                            <div class="invalid-feedback">Please provide a valid quantity.</div>
                        </div>
                    </div>
                    <div class="col-md-1 mt-2">
                        <button type="button" class="btn btn-danger remove-row" onclick="removeRow(this)">X</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-outline-secondary mb-2" id="add-more-btn">Add More Product</button>

            <!-- Total Sales Card -->
            <div class="total-sales-card w-25 text-center mb-2">
                <h5 class="total-sales-title">Total Sales</h5>
                <h6 class="total-sales-amount">GHS <span id="grand-total">0.00</span></h6>
            </div>

            <button type="submit" class="btn btn-outline-primary mt-3">Add Sale</button>
        </form>
    </div>
</main>

<script>
    function updatePrice(elem) {
        const row = $(elem).closest('.product-row');
        const productSelect = row.find('.product-select');
        const quantityInput = row.find('.quantity-input').val();
        const price = productSelect.find('option:selected').data('price') || 0;
        const totalPrice = quantityInput * price;

        // Create or update a hidden input to hold the total price for this row
        let totalPriceInput = row.find('.total-price');
        if (totalPriceInput.length === 0) {
            totalPriceInput = $('<input type="hidden" class="total-price" name="total_price[]" />');
            row.append(totalPriceInput);
        }
        totalPriceInput.val(totalPrice.toFixed(2));

        updateGrandTotal();
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        $('.total-price').each(function() {
            const price = parseFloat($(this).val()) || 0;
            grandTotal += price;
        });
        $('#grand-total').text(grandTotal.toFixed(2));
    }

    $('#add-more-btn').on('click', function() {
        const newRow = $('.product-row:first').clone();
        newRow.find('select').val('');
        newRow.find('input').val('');
        newRow.find('.total-price').remove(); // Remove any hidden total price input
        newRow.appendTo('#products-container');
    });

    function removeRow(btn) {
        if ($('.product-row').length > 1) {
            $(btn).closest('.product-row').remove();
            updateGrandTotal();
        }
    }

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
