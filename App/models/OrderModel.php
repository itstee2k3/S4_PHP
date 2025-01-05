<?php

require_once('app/config/database.php'); // Kết nối đến database

class OrderModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy danh sách tất cả các đơn hàng
    public function getAllOrders()
    {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy thông tin đơn hàng theo ID
    public function getOrderById($orderId)
    {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ); // Trả về đơn hàng duy nhất
    }

    // Xóa đơn hàng theo ID
    public function deleteOrder($orderId)
    {
        $query = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
    }
}

?>
