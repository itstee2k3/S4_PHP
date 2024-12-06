<?php
class CartModel
{
    private $conn;
    private $table_name = "carts";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($user_id, $product_id, $quantity = 1)
    {
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $query = "UPDATE " . $this->table_name . " 
                      SET quantity = quantity + :quantity 
                      WHERE user_id = :user_id AND product_id = :product_id";
        } else {
            // Nếu chưa tồn tại, thêm sản phẩm mới
            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) 
                      VALUES (:user_id, :product_id, :quantity)";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding to cart: " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
    public function getCartItems($user_id)
    {
        $query = "SELECT c.id as cart_id, p.id as product_id, p.name, p.price, c.quantity, p.image 
                  FROM " . $this->table_name . " c 
                  JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching cart items: " . $e->getMessage());
            return [];
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($user_id, $product_id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error removing from cart: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartQuantity($user_id, $product_id, $quantity)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET quantity = :quantity 
                  WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        try {
            $result = $stmt->execute();
            if (!$result) {
                error_log("Update failed: " . implode(', ', $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating cart quantity: " . $e->getMessage());
            return false;
        }
    }

    // Xóa toàn bộ giỏ hàng của người dùng
    public function clearCart($user_id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }
}
