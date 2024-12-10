<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CartModel.php');

class CartController {
    private $productModel;
    private $cartModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->cartModel = new CartModel($this->db);
        $this->productModel = new ProductModel($this->db);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id): void {
        $product = $this->productModel->getproductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['message'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.";
            $_SESSION['message_type'] = 'warning'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $quantity = 1; // Số lượng mặc định
        if ($this->cartModel->addToCart(user_id: $user_id, product_id: $id, quantity: $quantity)) {
            $_SESSION['message'] = "Đã thêm sản phẩm vào giỏ hàng thành công.";
            $_SESSION['message_type'] = 'success'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.";
        }
    }

    // Hiển thị giỏ hàng
    public function index() {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            // echo "Vui lòng đăng nhập để xem giỏ hàng.";
            $_SESSION['message'] = 'Vui lòng đăng nhập để xem giỏ hàng.';
            $_SESSION['message_type'] = 'warning'; // hoặc 'danger', 'info', 'success'
            
            header('Location:' . $_SERVER['HTTP_REFERER']);
            // include 'app/views/cart/cart.php';
            exit;
        }
    
        // $cartItems = $this->cartModel->getCartItems($user_id);
        $cart = $this->cartModel->getCartItems($user_id);

        $data = ['cart' => $cart];
        extract($data);
    
        include __DIR__ . '/../views/cart/cart.php';
    }
    

    // Checkout
    public function checkout() {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['message'] = 'Vui lòng đăng nhập để tiếp tục.';
            $_SESSION['message_type'] = 'warning';
            header('Location: /s4_php/account/login');
            exit;
        }

        // Lấy giỏ hàng của người dùng
        $cart = $this->cartModel->getCartItems($user_id);

        // Tính tổng số tiền
        $totalPrice = array_reduce($cart, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $data = [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ];

        extract($data);
        include 'app/views/cart/checkout.php';
    }

    // Xử lý checkout
    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $phone = $_POST['phone'];
            $address = $_POST['address'];
    
            // Kiểm tra dữ liệu đầu vào
            if (empty($phone) || empty($address)) {
                echo "Vui lòng nhập đầy đủ thông tin.";
                return;
            }
    
            $user_id = $_SESSION['user_id'] ?? null;
            if (!$user_id) {
                echo "Vui lòng đăng nhập để tiếp tục.";
                return;
            }
    
            // Lấy giỏ hàng
            $cart = $this->cartModel->getCartItems($user_id);
            if (empty($cart)) {
                echo "Giỏ hàng trống.";
                return;
            }
    
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng vào bảng `orders`
                $query = "INSERT INTO orders (user_id, phone, address, created_at) 
                          VALUES (:user_id, :phone, :address, NOW())";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId(); // Lấy ID của đơn hàng vừa tạo
    
                // Lưu chi tiết đơn hàng vào bảng `order_details`
                foreach ($cart as $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity) 
                              VALUES (:order_id, :product_id, :quantity)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $item['product_id']);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->execute();
                }
    
                // Xóa giỏ hàng sau khi hoàn tất đặt hàng
                $this->cartModel->clearCart($user_id);
    
                // Hoàn tất giao dịch
                $this->db->commit();
    
                // Chuyển đến trang xác nhận đặt hàng
                header('Location: /s4_php/cart/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack(); // Hoàn tác giao dịch nếu có lỗi
                echo "Đã xảy ra lỗi: " . $e->getMessage();
            }
        }
    }
    

    public function updateQuantity($product_id)
    {
        // Kiểm tra phương thức HTTP
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = intval($_POST['quantity']);
            $user_id = $_SESSION['user_id']; // Giả sử user_id được lưu trong session

            // Kiểm tra số lượng hợp lệ
            if ($quantity <= 0) {
                $_SESSION['error'] = 'Số lượng không hợp lệ!';
                header("Location: /s4_php/cart");
                exit;
            }
    
            // Cập nhật số lượng trong database
            $cartModel = new CartModel($this->db); // Giả sử bạn đã có Model Cart
            $result = $cartModel->updateCartQuantity($user_id, $product_id, $quantity);
    
            if ($result) {
                $_SESSION['message'] = 'Cập nhật số lượng thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                $_SESSION['message_type'] = 'error';
            }
    
            // Quay lại trang giỏ hàng
            // header("Location: /s4_php/cart");
            // exit;
            $cart = $cartModel->getCartItems($user_id); // Lấy lại giỏ hàng mới
            include 'app/views/cart/cart.php'; // Gửi lại view với dữ liệu mới
            exit;
        }
    }

    public function remove($product_id)
    {
        $user_id = $_SESSION['user_id'];  // Lấy user_id từ session, giả sử user đã đăng nhập

        // Gọi hàm remove từ model CartModel
        $cartModel = new CartModel($this->db);
        $result = $cartModel->removeFromCart($user_id, $product_id);

        if ($result) {
            $_SESSION['message'] = 'Sản phẩm đã được xóa khỏi giỏ hàng.';
            $_SESSION['message_type'] = 'warning';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa sản phẩm.';
        }

        // Quay lại trang giỏ hàng
        header("Location: /s4_php/cart");
        exit;
    }

    public function orderConfirmation() {
        include 'app/views/cart/orderConfirmation.php';
    }
}
?>
