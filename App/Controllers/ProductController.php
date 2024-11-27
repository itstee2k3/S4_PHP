<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Config\Database;
use Exception;


class ProductController
{
    private $db;
    private $productModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }


    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
           
            $category_id = $_POST['category_id'] ?? null;

            $errors = []; // Mảng lưu trữ lỗi

            try {
                // Kiểm tra và upload ảnh
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image = $this->uploadImage($_FILES['image']);
                } else {
                    $image = "";
                }


                // Thêm sản phẩm vào database
                $result = $this->productModel->addProduct(
                    $name,
                    $description,
                    $category_id,
                    $image
                );

                if (is_array($result)) {
                    $errors = array_merge($errors, $result); // Ghép lỗi từ model
                } else {
                    header('Location: /demo1/Product');
                    exit;
                }
            } catch (Exception $e) {
            

                // Ghi nhận lỗi trong quá trình upload ảnh
                $errors[] = $e->getMessage();
            }

            // Lấy danh mục và hiển thị view cùng lỗi
            $categories = (new CategoryModel($this->db))->getCategories();
            include 'app/views/product/add.php';
        }
    }


    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );

            if ($edit) {
                header('Location: /s4_php/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /s4_php/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "public/images/";
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
            "jpeg" && $imageFileType != "gif"
        ) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToFavorites($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['favorites'])) {
            $_SESSION['favorites'] = [];
        }
        if (!isset($_SESSION['favorites'][$id])) {
            // Thêm sản phẩm vào danh sách yêu thích
            $_SESSION['favorites'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image
            ];
        }
        // Chuyển hướng đến trang danh sách yêu thích
        header('Location: /s4_php/Product/favorites');
    }

    public function favorites()
    {
        // Kiểm tra và xóa sản phẩm quá hạn 30 ngày
         $this->checkFavoritesExpiration();
        // Lấy danh sách yêu thích từ session
        $favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];
        include 'app/views/product/favorites.php';
    }
    public function removeFromFavorites($id)
    {
        if (isset($_SESSION['favorites'][$id])) {
            // Xóa sản phẩm khỏi danh sách yêu thích
            unset($_SESSION['favorites'][$id]);
        }
        // Chuyển hướng về trang danh sách yêu thích
        header('Location: /s4_php/Product/favorites');
    }

    public function checkFavoritesExpiration()
    {
        if (isset($_SESSION['favorites'])) {
            $current_time = time(); // Lấy thời gian hiện tại
            $expire_time = 30 * 24 * 60 * 60; // 30 ngày tính bằng giây

            // Duyệt qua từng sản phẩm trong danh sách yêu thích
            foreach ($_SESSION['favorites'] as $id => $item) {
                if ($current_time - $item['timestamp'] > $expire_time) {
                    // Nếu thời gian sản phẩm đã quá 30 ngày, xóa sản phẩm khỏi danh sách yêu thích
                    unset($_SESSION['favorites'][$id]);
                }
            }
        }
    }
}
