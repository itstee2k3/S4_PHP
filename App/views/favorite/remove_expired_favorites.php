<?php
require_once __DIR__ . '/../../config/database.php'; // Đường dẫn chính xác tới file database
require_once __DIR__ . '/../../models/FavoriteModel.php'; // Đường dẫn tới model

$db = (new Database())->getConnection(); // Tạo kết nối database
if ($db === null) {
    exit("Database connection failed.\n");
}

$favoriteModel = new FavoriteModel($db);

// Xóa các sản phẩm yêu thích đã hết hạn
// $favoriteModel->removeExpiredFavorites();

// echo "Expired favorites removed successfully.\n";
?>
