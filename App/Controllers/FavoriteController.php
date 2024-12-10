<?php
require_once 'app/models/FavoriteModel.php';
require_once('app/config/database.php');

class FavoriteController {
    private $favoriteModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->favoriteModel = new FavoriteModel($this->db);
    }

    public function addToFavorites($product_id) {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm vào yêu thích.";
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    
        // Thêm sản phẩm vào danh sách yêu thích
        if ($this->favoriteModel->addFavorite($user_id, $product_id)) {
            $_SESSION['success'] = "Đã thêm vào danh sách yêu thích.";
            $_SESSION['message_type'] = 'success'; // hoặc 'danger', 'info', 'success'
        } else {
            $_SESSION['error'] = "Sản phẩm đã có trong danh sách yêu thích.";
        }
    
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }
    

    public function removeFromFavorites($product_id) {
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xoá sản phẩm khỏi yêu thích.";
            header('Location: /s4_php/account/login');
            exit;
        }

        if ($this->favoriteModel->removeFavorite($user_id, $product_id)) {
            $_SESSION['success'] = "Đã xoá khỏi danh sách yêu thích.";
        } else {
            $_SESSION['error'] = "Không thể xoá sản phẩm.";
        }

        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    public function index() {

        // Xóa sản phẩm hết hạn trước khi lấy danh sách yêu thích
        // $this->favoriteModel->removeExpiredFavorites();
        
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['message'] = 'Vui lòng đăng nhập để xem danh sách yêu thích.';
            $_SESSION['message_type'] = 'warning'; // hoặc 'danger', 'info', 'success'

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    
        // Lấy danh sách sản phẩm yêu thích của người dùng từ model
        $favorites = $this->favoriteModel->getUserFavorites($user_id);

        // Kiểm tra và gán thời gian đã trôi qua cho mỗi sản phẩm
        // foreach ($favorites as &$product) {
        //     $product['time_elapsed'] = $this->favoriteModel->calculateTimeElapsed($product['created_at']);
        // }

        if ($favorites) {
            include 'app/views/favorite/list.php';
        } else {
            $_SESSION['message'] = 'Không có sản phẩm yêu thích nào.';
            $_SESSION['message_type'] = 'warning'; // hoặc 'danger', 'info', 'success'

            include 'app/views/favorite/list.php';
        }
    }
    
}
?>
