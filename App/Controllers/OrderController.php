<?php

require_once('app/models/OrderModel.php'); // Bao gồm OrderModel

class OrderController
{
    private $orderModel;

    public function __construct($db)
    {
        $this->orderModel = new OrderModel($db); // Khởi tạo model
    }

    // Hiển thị danh sách các đơn hàng
    public function index()
    {
        $orders = $this->orderModel->getAllOrders();
        include_once 'app/admin/views/order/index.php';
    }

    // Sửa thông tin đơn hàng
    public function edit($orderId)
    {
        // Lấy thông tin đơn hàng cần sửa
        $order = $this->orderModel->getOrderById($orderId);

        // Gửi dữ liệu tới view
        include_once 'app/admin/views/order/edit.php';
    }

    // Xóa đơn hàng
    public function delete($orderId)
    {
        // Xóa đơn hàng khỏi database
        $this->orderModel->deleteOrder($orderId);

        // Điều hướng lại đến danh sách đơn hàng
        header('Location: /s4_php/admin/orders');
        exit();
    }
}

?>
