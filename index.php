<?php
session_start();
require 'vendor/autoload.php';

use App\Models\ProductModel;
use App\Controllers\DefaultController;

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' :
'DefaultController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('App/Controllers/' . $controllerName . '.php')) {
// Xử lý không tìm thấy controller
die('Controller not found');
}

//   $controller = new $controllerName();
 $controller = new ("App\\Controllers\\" . $controllerName)();


if (!method_exists($controller, $action)) {
// Xử lý không tìm thấy action
var_dump($action);
die;
die('Action not found');
}
// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));