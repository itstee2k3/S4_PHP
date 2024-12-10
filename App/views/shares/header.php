<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        .product-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/s4_php/product/">Danh sách sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/s4_php/product/add">Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/s4_php/cart/">Giỏ hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/s4_php/favorite/">Sản phẩm yêu thích</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php
                        if (SessionHelper::isLoggedIn()) {
                            echo "<span class='nav-link'>" . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . "</span>";
                        } else {
                            echo "<a class='nav-link' href='/s4_php/account/login'>Login</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (SessionHelper::isLoggedIn()) {
                            echo "<a class='nav-link' href='/s4_php/account/logout'>Logout</a>";
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if (isset($_SESSION['message']) || isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type'] ?? ($_SESSION['success'] ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
            <?php 
            // Hiển thị thông báo
            echo $_SESSION['message'] ?? $_SESSION['success'] ?? $_SESSION['error']; 
            
            // Xóa thông báo sau khi hiển thị
            unset($_SESSION['message']);
            unset($_SESSION['success']);
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- <div class="container mt-4"></div> -->
