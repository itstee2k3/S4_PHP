<?php
class FavoriteModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function removeFavorite($user_id, $product_id) {
        $query = "DELETE FROM favorites WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    // public function getUserFavorites($user_id) {
    //     $stmt = $this->db->prepare("SELECT p.id, p.name, p.price, p.image FROM products p 
    //                                 JOIN favorites f ON p.id = f.product_id
    //                                 WHERE f.user_id = ?");
    //     $stmt->execute([$user_id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Trả về mảng kết quả
    // }
    
    public function getUserFavorites($user_id) {
        $stmt = $this->db->prepare("SELECT p.id, p.name, p.price, p.image, f.created_at
                                    FROM products p 
                                    JOIN favorites f ON p.id = f.product_id
                                    WHERE f.user_id = ?");
        $stmt->execute([$user_id]);
        $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Tính toán thời gian đã trôi qua kể từ khi sản phẩm được thêm vào
        foreach ($favorites as &$favorite) {
            $favorite['time_elapsed'] = $this->calculateTimeElapsed($favorite['created_at']);
        }
    
        return $favorites;
    }

    public function calculateTimeElapsed($created_at) {
        // Chuyển đổi thời gian lưu vào đối tượng DateTime với múi giờ chính xác
        $created_at = new DateTime($created_at, new DateTimeZone('Asia/Ho_Chi_Minh')); // Đảm bảo múi giờ đúng
        $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')); // Cũng đảm bảo múi giờ đúng
        $interval = $created_at->diff($now);
    
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;
    
        if ($interval->y > 0) {
            return $interval->y . ' năm trước';
        } elseif ($interval->m > 0) {
            return $interval->m . ' tháng trước';
        } elseif ($days > 0) {
            return $days . ' ngày ' . $hours . ' giờ ' . $minutes . ' phút ' . $seconds . ' giây trước';
        } elseif ($hours > 0) {
            return $hours . ' giờ ' . $minutes . ' phút ' . $seconds . ' giây trước';
        } elseif ($minutes > 0) {
            return $minutes . ' phút ' . $seconds . ' giây trước';
        } else {
            return $seconds . ' giây trước';
        }
    }
    

    public function addFavorite($user_id, $product_id) {
        // Kiểm tra nếu sản phẩm đã có trong danh sách yêu thích
        $stmt = $this->db->prepare("SELECT * FROM favorites WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        if ($stmt->rowCount() > 0) {
            return false; // Sản phẩm đã có trong danh sách yêu thích
        }
    
        // Thêm sản phẩm vào danh sách yêu thích
        $stmt = $this->db->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $product_id]);
    }

     // Thêm phương thức xóa sản phẩm sau 1 phút
     public function removeExpiredFavorites() {
        try {
            $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $nowFormatted = $now->format('Y-m-d H:i:s');
    
            $query = "DELETE FROM favorites WHERE TIMESTAMPDIFF(SECOND, created_at, ?) > 60";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nowFormatted]);
    
            echo "Expired favorites removed successfully.\n"; // Debug thông báo khi xóa thành công
        } catch (Exception $e) {
            echo "Error in removeExpiredFavorites: " . $e->getMessage() . "\n";
        }
    }
    
}
?>
