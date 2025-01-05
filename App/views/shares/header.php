<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <?php
        $base_path = '';
        // Kiểm tra nếu đường dẫn hiện tại chứa `/product/show/` và thêm một cấp
        if (strpos($_SERVER['REQUEST_URI'], '/product/show/') !== false) {
            $base_path = '../';  // Thêm một cấp
        }
    ?>

    <!-- Favicon -->
    <link href="<?php echo $base_path; ?>../public/user/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo $base_path; ?>../public/user/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $base_path; ?>../public/user/css/style.css" rel="stylesheet">
    
    <style>
        /* Container thông báo */
        .toast-container {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9999;
            width: 300px;
            max-width: 100%;
            display: flex;
            flex-direction: column; /* Đổi từ column-reverse thành column */
            gap: 10px; /* Khoảng cách giữa các thông báo */
        }


        /* Nội dung thông báo */
        .toast-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
            animation: fadeIn 0.5s ease-out, fadeOut 0.5s ease-in 4.5s;
        }

        /* Các loại thông báo */
        .toast-content.success {
            background-color: #28a745; /* Xanh lá */
        }

        .toast-content.error {
            background-color: #dc3545; /* Đỏ */
        }

        /* Các loại thông báo */
        .toast-content.warning {
            background-color: #ffc107; /* Màu vàng */
            color: #212529; /* Màu chữ đen */
        }


        /* Nút đóng */
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* Hiệu ứng fade in và fade out */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateY(-20px); }
        }

    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
    
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group border" style="overflow: hidden;">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        <!-- Trong header.php -->
        <div class="col-lg-3 col-6 text-right">
            <a href="/s4_php/favorite/" class="btn border">
                <i class="fas fa-heart text-primary"></i>
                <span class="badge"><?php echo isset($favoriteCount) ? $favoriteCount : 0; ?></span>
            </a>
            <a href="/s4_php/cart/" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge"><?php echo isset($cartCount) ? $cartCount : 0; ?></span>
            </a>
        </div>

        
<!-- Debugging: In ra giá trị -->
<!-- <?php
    echo "Favorite Count: " . $favoriteCount . "<br>";
    echo "Cart Count: " . $cartCount . "<br>";
?> -->

        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="/s4_php/product/" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/product/') ? 'active' : ''; ?>">Home</a>
                            <a href="/s4_php/product/shop" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/product/shop') ? 'active' : ''; ?>">Shop</a>
                            <a href="/s4_php/contact/" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/contact/') ? 'active' : ''; ?>">Contact</a>
                        </div>

                        <div class="navbar-nav ml-auto py-0">
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="#" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/account/profile') ? 'active' : ''; ?>">
                                    <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                                <a href="/s4_php/account/logout" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/account/logout') ? 'active' : ''; ?>">Logout</a>
                            <?php else: ?>
                                <a href="/s4_php/account/login" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/account/login') ? 'active' : ''; ?>">Login</a>
                                <a href="/s4_php/account/register" class="nav-item nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/s4_php/account/register') ? 'active' : ''; ?>">Register</a>
                            <?php endif; ?>
                        </div>


                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <div id="toast-container" class="toast-container">
        <?php if (isset($_SESSION['message']) || isset($_SESSION['success']) || isset($_SESSION['error']) || isset($_SESSION['warning'])): ?>
            <script>
                // Lưu thông báo vào sessionStorage
                sessionStorage.setItem('toastMessage', JSON.stringify({
                    message: '<?php echo $_SESSION['message'] ?? $_SESSION['success'] ?? $_SESSION['error'] ?? $_SESSION['warning']; ?>',
                    type: '<?php echo $_SESSION['message_type'] ?? ($_SESSION['success'] ? 'success' : ($_SESSION['error'] ? 'error' : 'warning')); ?>'
                }));
                
                // Xóa thông báo trong $_SESSION sau khi hiển thị
                <?php unset($_SESSION['message'], $_SESSION['success'], $_SESSION['error'], $_SESSION['warning']); ?>
            </script>
        <?php endif; ?>
    </div>


<script>
    // Lưu vị trí cuộn trước khi rời khỏi trang
    window.addEventListener("beforeunload", () => {
        localStorage.setItem("scrollPosition", window.scrollY);
    });

    // Khôi phục vị trí cuộn khi tải lại
    window.addEventListener("load", () => {
        const scrollPosition = localStorage.getItem("scrollPosition");
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition, 10));
            localStorage.removeItem("scrollPosition");
        }
        const storedToast = sessionStorage.getItem('toastMessage');
        if (storedToast) {
            const { message, type } = JSON.parse(storedToast);
            addToast(message, type); // Hiển thị lại thông báo từ sessionStorage
            sessionStorage.removeItem('toastMessage'); // Xóa thông báo sau khi hiển thị
        }
    });

    // Hàm thêm thông báo
    function addToast(message, type = 'success') {
        const container = document.getElementById('toast-container');

        // Xóa tất cả thông báo cũ
        container.innerHTML = '';

        // Tạo thông báo mới
        const toast = document.createElement('div');
        toast.className = `toast-content ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button class="close-btn" onclick="this.parentElement.remove();">&times;</button>
        `;

        // Thêm thông báo mới vào container
        container.appendChild(toast);

        // Tự động ẩn thông báo sau 5 giây
        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.5s ease-in forwards';
            setTimeout(() => {
                toast.remove(); // Xóa thông báo khỏi DOM
            }, 500); // Chờ hiệu ứng fadeOut hoàn tất
        }, 5000);
    }
</script>
