<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/AccountModel.php');
require_once('app/models/CategoryModel.php');

class AdminController
{
    private $accountModel;
    private $productModel;
    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
        if (!isset($_SESSION['user_roles']) || !in_array('Admin', $_SESSION['user_roles'])) {
            $_SESSION['message'] = 'Bạn không có quyền truy cập vào trang quản trị.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /s4_php/');
            exit;
        }
    }

    public function dashboard()
    {
        // $productModel = new ProductModel((new Database())->getConnection());
        // $products = $productModel->getProducts(); // Lấy danh sách sản phẩm
        include 'app/admin/shares/header.php';
        include 'app/admin/views/dashboard/dashboard.php';
        include 'app/admin/shares/footer.php';
    }

    public function users()
    {
        $users = $this->accountModel->getAllUsers(); // Lấy danh sách User
        $accountModel = $this->accountModel; // Để sử dụng trong view
        include 'app/admin/shares/header.php';
        include 'app/admin/views/user/index.php';
        include 'app/admin/shares/footer.php';
    }

    public function products()
    {
        $products = $this->productModel->getproducts(); // Lấy danh sách User
        $productModel = $this->productModel; // Để sử dụng trong view
        include 'app/admin/shares/header.php';
        include 'app/admin/views/product/index.php';
        include 'app/admin/shares/footer.php';
    }

    public function categories()
    {
        $categories = $this->categoryModel->getCategories(); // Lấy danh sách User
        $categoryModel = $this->categoryModel; // Để sử dụng trong view
        include 'app/admin/shares/header.php';
        include 'app/admin/views/category/index.php';
        include 'app/admin/shares/footer.php';
    }
}
