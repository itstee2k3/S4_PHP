<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class productController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new productModel($this->db);
    }

    public function index(): void
    {
        // echo 'This is the product index page'; // Debug message
        $products = $this->productModel->getproducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getproductById($id);
        if ($product) {
            include 'app/views/product/show.php';
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
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = "";

            $product = $this->productModel->addproduct($name, $description, $price, $category_id, image: $image);
            if (isset($product['error'])) {
                $errors[] = $product['error']; // Nếu có lỗi khi thêm sản phẩm
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
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
                header('Location: /s4_php/product');
                exit;
            } else {
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            }
            // if (is_array($product)) {
            //     // $errors = $product;
            //     if (isset($product['id_error'])) {
            //         $errors = ['Không thể tạo ID cho sản phẩm mới.']; // Hoặc lỗi cụ thể về ID
            //     } else {
            //         $errors = $product; // Lỗi khác (ví dụ: không thể thêm sản phẩm)
            //     }
            //     $categories = (new CategoryModel($this->db))->getCategories();
            //     include 'app/views/product/add.php';
            // } else {
            //     header('Location: /s4_php/product');
            // }
        }
    }


    public function edit($id)
    {
        $product = $this->productModel->getproductById($id);
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
                header('Location: /s4_php/product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteproduct($id)) {
            header('Location: /s4_php/product');
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
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
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
