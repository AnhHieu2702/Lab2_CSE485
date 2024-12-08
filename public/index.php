<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('\\', '/', dirname(__DIR__)));
}

require_once APP_ROOT . '/app/config/config.php';
require_once APP_ROOT . '/app/controllers/AuthController.php';
require_once APP_ROOT . '/app/controllers/NewController.php';
require_once APP_ROOT . '/app/controllers/CategoryController.php';
require_once APP_ROOT . '/app/controllers/UserController.php';

$controllerAuth = new AuthController();
$controllerNew= new NewController();
$controllerCate= new CategoryController();
$controllerUser= new UserController();

$action = isset($_GET['action']) ? $_GET['action'] : 'change';

switch ($action) {
    case 'login':
        $controllerAuth->login();
        break;
    case 'change':
        $controllerAuth->changePassword();
        break;
    case 'logout':
        $controllerAuth->logout();
        break;
    case 'admin_user':
        $controllerUser->index();
        break;
    case 'admin_new':
        $controllerCate->index();
        break;
    case 'user':
        $controllerNew->index();
        break;
    default:
        $controllerAuth->login();  // Nếu không có action hợp lệ, chuyển đến trang login mặc định
        break;
}

