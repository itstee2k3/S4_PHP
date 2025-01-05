<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/FavoriteModel.php');
require_once('app/controllers/AccountController.php');

class productController
{
    private $productModel;
    private $favoriteModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new productModel($this->db);
        $this->favoriteModel = new favoriteModel($this->db);
    }

    public function index(): void
    {
        // $accountController = new AccountController();

        // if (!isset($_SESSION['user_id'])) {
        //     if (!$accountController->autoLogin()) {
        //         echo "Vui lòng đăng nhập lại.";
        //         header('Location: /s4_php/account/login');
        //         exit;
        //     }
        // }

        $user_id = $_SESSION['user_id'] ?? null;

        // Nếu người dùng đã đăng nhập, lấy danh sách yêu thích
        $favorite_product_ids = [];
        if ($user_id) {
            $favorites = $this->favoriteModel->getUserFavorites($user_id);
            $favorite_product_ids = array_map(function($favorite) {
                return $favorite['id'];
            }, $favorites);
        }

        // echo 'This is the product index page'; // Debug message
        $products = $this->productModel->getproducts();
        include 'app/views/product/list.php';
    }

    public function shop(): void
    {

        $user_id = $_SESSION['user_id'] ?? null;

        // Nếu người dùng đã đăng nhập, lấy danh sách yêu thích
        $favorite_product_ids = [];
        if ($user_id) {
            $favorites = $this->favoriteModel->getUserFavorites($user_id);
            $favorite_product_ids = array_map(function($favorite) {
                return $favorite['id'];
            }, $favorites);
        }

        // echo 'This is the product index page'; // Debug message
        $products = $this->productModel->getproducts();
        include 'app/views/product/shop.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getproductById($id);

        if ($product) {

            $user_id = $_SESSION['user_id'] ?? null;

            // Nếu người dùng đã đăng nhập, lấy danh sách yêu thích
            $favorite_product_ids = [];
            if ($user_id) {
                $favorites = $this->favoriteModel->getUserFavorites($user_id);
                $favorite_product_ids = array_map(function($favorite) {
                    return $favorite['id'];
                }, $favorites);
            }

            // echo 'This is the product index page'; // Debug message
            $products = $this->productModel->getproducts();
            include 'app/views/shares/header.php';
            include 'app/views/product/detail.php';
            include 'app/views/shares/footer.php'; 

        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        if (!isset($_SESSION['user_roles']) || !is_array($_SESSION['user_roles']) || !in_array('Admin', $_SESSION['user_roles'])) {
            // echo "Bạn không có quyền thực hiện chức năng này.";
            $_SESSION['message'] = 'Bạn không có quyền thực hiện chức năng này.';
            $_SESSION['message_type'] = 'danger'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit; // Dừng thực hiện
        }

        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/admin/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = "";

            $product = $this->productModel->addproduct($name, $description, $price, $category_id, image: $image);
            if (isset($product['error'])) {
                $errors[] = $product['error']; // Nếu có lỗi khi thêm sản phẩm
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/admin/views/product/add.php';
                return;
            } else {
                $productId = $product['id'];
                if (!$productId) {
                    $errors[] = 'Không thể tạo ID cho sản phẩm. Vui lòng thử lại.';
                }
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    $image = $this->uploadImage($_FILES['image'], $productId);
                    $this->productModel->updateproduct($productId, $name, $description, $price, $category_id, $image);
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            // Chuyển hướng sau khi lưu
            if (empty($errors)) {
                $_SESSION['message'] = 'Tạo mới thành công sản phẩm ' . $name;
                $_SESSION['message_type'] = 'success'; // hoặc 'danger', 'info', 'success'
                header('Location: /s4_php/admin/products');
                exit;
            } else {
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/admin/views/product/add.php';
            }
        }
    }


    public function edit($id)
    {
        if (!in_array('Admin', $_SESSION['user_roles'])) {
            // echo "Bạn không có quyền thực hiện chức năng này.";
            $_SESSION['message'] = 'Bạn không có quyền thực hiện chức năng này.';
            $_SESSION['message_type'] = 'danger'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit; // Dừng thực hiện
        }

        $product = $this->productModel->getproductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/admin/views/product/edit.php';
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
            $existingImage = $_POST['existing_image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image'], $id);
                
                if ($existingImage && file_exists("public/images/" . $existingImage)) {
                    unlink("public/images/" . $existingImage);  // Xóa ảnh cũ
                }
            } else {
                $image = $existingImage;
            }
            $edit = $this->productModel->updateproduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if ($edit) {
                header('Location: /s4_php/admin/products');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if (!in_array('Admin', $_SESSION['user_roles'])) {
            // echo "Bạn không có quyền thực hiện chức năng này.";
            $_SESSION['message'] = 'Bạn không có quyền thực hiện chức năng này.';
            $_SESSION['message_type'] = 'danger'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit; // Dừng thực hiện
        }

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "Sản phẩm không tồn tại.";
            return;
        }

        // Xóa ảnh nếu tồn tại
        $imagePath = "public/images/" . $product->image;
        if (!empty($product->image) && file_exists($imagePath)) {
            if (unlink(filename: $imagePath)) {
                $_SESSION['success'] = "Sản phẩm và ảnh đã được xóa thành công.";
            } else {
                $_SESSION['error'] = "Sản phẩm đã được xóa nhưng không thể xóa ảnh.";
            }
        } else {
            $_SESSION['warning'] = "Sản phẩm đã xóa, nhưng không tìm thấy ảnh để xóa.";
        }
        
        if ($this->productModel->deleteproduct($id)) {
            $_SESSION['message'] = 'Xóa sản phẩm thành công';
            $_SESSION['message_type'] = 'success'; // hoặc 'danger', 'info', 'success'
            header('Location: /s4_php/admin/products');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }


    private function uploadImage($file, $productId)
    {
        $baseDir = realpath(__DIR__ . "/../../");

        $target_dir = $baseDir . "/public/images/";

        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                throw new Exception("Không thể tạo thư mục tải lên: $target_dir. Kiểm tra quyền.");
            }
        }

         // Nếu có ID sản phẩm, dùng ID để đặt tên ảnh
        if ($productId) {
            // Tạo tên file theo ID sản phẩm (ví dụ: 123.jpg)
            $filename = "product-" . $productId . '.' . strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        } else {
            // Nếu không có ID, chỉ sử dụng tên gốc (hoặc có thể thay đổi tên theo nhu cầu)
            $filename = basename($file["name"]);
        }

        
        // $filename = basename($file["name"]);
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!is_writable($target_dir)) {
            throw new Exception("Thư mục $target_dir không thể ghi. Kiểm tra quyền.");
        }
        
        if (!is_writable(dirname($target_file))) {
            throw new Exception("Thư mục đích không thể ghi: " . dirname($target_file));
        }
        
        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        var_dump($file["tmp_name"]);

        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "avif" && $imageFileType != "webp") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        var_dump($file["tmp_name"]);

        // luu file
        var_dump($target_file); // Kiểm tra đường dẫn lưu trữ
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            $error = error_get_last();
            error_log("File upload failed: " . print_r($error, true)); // Ghi lỗi vào log
            throw new Exception(message: "Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $filename;
    }

}
