<?php
include 'config.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/.10.5/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="style.css">
<header class="navbar">
    <a class="navbar-brand fs-5 text-white ps-5" href="#">BookShop </a>
</header>
<nav class="sidebar">
    <ul class="top1 nav flex-column mb-auto">
        <!-- Dashboard -->
        <li class="nav-item mb-3">
            <a href="dashboard.php" class="nav-link dashboard text-white" aria-current="page">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>
        <!-- Products -->
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-box-seam me-2"></i>
                Products
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-eye me-2"></i>
                View Products
            </a>
        </li>
        <!-- Daily Sales -->
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-cash me-2"></i>
                Daily Sales
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-graph-up-arrow me-2"></i>
                View Daily Sales
            </a>
        </li>
        <!-- Weekly Sales -->
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-calendar3-week me-2"></i>
                Weekly Sales
            </a>
        </li>
        <!-- Creditors -->
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-people me-2"></i>
                Creditors
            </a>
        </li>
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-eye me-2"></i>
                View Creditors
            </a>
        </li>
        <!-- Reports -->
        <li class="nav-item mb-3">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-bar-chart-fill me-2"></i>
                Reports
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="#">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Sign out
                </a>
            </li>
        </ul>
    </div>
</nav>
