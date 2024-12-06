<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('\\', '/', dirname(__DIR__)));  // Đảm bảo APP_ROOT chỉ được định nghĩa một lần
}

require_once APP_ROOT . '/app/config/config.php';  // Bao gồm cấu hình cơ sở dữ liệu, v.v.
require_once APP_ROOT . '/app/controllers/AuthController.php';  // Bao gồm controller xử lý auth

$controller = new AuthController();

$action = isset($_GET['action']) ? $_GET['action'] : 'change'; // Action mặc định là login nếu không có

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'change':
        $controller->changePassword();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->login();  // Nếu không có action hợp lệ, chuyển đến trang login mặc định
        break;
}

