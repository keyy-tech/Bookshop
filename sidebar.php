<?php
include 'config.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="style.css">
<nav class="sidebar">
    <ul class="top1 nav flex-column mb-auto">
        <!-- Products -->
        <li class="nav-item mb-3 mt-3">
            <a href="add_product.php" class="nav-link text-black">
                <i class="bi bi-box-seam me-2"></i>
                Products
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="view_product.php" class="nav-link text-black">
                <i class="bi bi-eye me-2"></i>
                View Products
            </a>
        </li>
        <!-- Daily Sales -->
        <li class="nav-item mb-3">
            <a href="add_sales.php" class="nav-link text-black">
                <i class="bi bi-cash me-2"></i>
                Daily Sales
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="view_sales.php" class="nav-link text-black">
                <i class="bi bi-graph-up-arrow me-2"></i>
                View Daily Sales
            </a>
        </li>
        <!-- Weekly Sales -->
        <li class="nav-item mb-3">
            <a href="view_week.php" class="nav-link text-black">
                <i class="bi bi-calendar3-week me-2"></i>
                Weekly Sales
            </a>
        </li>
    </ul>
</nav>
