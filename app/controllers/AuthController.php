<?php
require_once __DIR__ . '/../services/AuthService.php';

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }
    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->authService->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;

                if ($user['role'] == 1) { // Admin
                    header('Location: http://localhost/tlunews/public/index.php?action=admin_dashboard');
                } else {
                    header('Location: http://localhost/tlunews/public/index.php?action=user');
                }
                exit();
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include APP_ROOT . '/app/views/auth/login.php';
            }
        } else {
            include APP_ROOT . '/app/views/auth/login.php';
        }
    }

    // Xử lý đổi mật khẩu
    public function changePassword()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = htmlspecialchars($_POST['current_password']);
            $newPassword = htmlspecialchars($_POST['new_password']);
            $userId = $_SESSION['user']['id'];

            if ($this->authService->changePassword($userId, $currentPassword, $newPassword)) {
                $success = "Đổi mật khẩu thành công.";
            } else {
                $error = "Mật khẩu cũ không đúng hoặc có lỗi xảy ra.";
            }
        }

        include APP_ROOT . '/app/views/auth/change_password.php';
    }

    // Xử lý đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . APP_ROOT . '/public/login.php');
        exit();
    }
}
