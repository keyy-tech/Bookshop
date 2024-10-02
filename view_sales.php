<?php
global $conn;
include 'config.php'; // Ensure your database connection is established
session_start();

// Fetch sales data from the DailySales view
$salesQuery = "SELECT sale_date, total_items_sold, total_sales FROM DailySales";
$salesResult = $conn->query($salesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Daily Sales - BookShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.js"></script>
    <style>
        /* Add some custom styles for spacing */
        table {
            margin-top: 20px;
        }
        th, td {
            padding: 15px; /* Add padding for table cells */
            text-align: center; /* Center align the text in the cells */
        }
        tr {
            margin-bottom: 10px; /* Add margin between table rows */
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<main>
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-1 border-bottom pt-1 mt-3">
            <h1 class="h4">Daily Sales Overview</h1>
        </div>

        <!-- Display sales data -->
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>Sale Date</th>
                    <th>Total Items Sold</th>
                    <th>Total Sales (GHS)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($salesResult->num_rows > 0): ?>
                    <?php while ($sale = $salesResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $sale['sale_date']; ?></td>
                            <td><?php echo $sale['total_items_sold']; ?></td>
                            <td>GHS <?php echo number_format($sale['total_sales'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No sales data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
