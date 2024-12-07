<?php
require_once __DIR__ . '/../services/AuthService.php';

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    // Xử lý đăng nhập
    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $user = $this->authService->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                // Điều hướng dựa vào vai trò
                if ($user['role'] == 1) { // Admin
                    header('Location: /tlunews/public/admin_dashboard.php');
                } else { // Người dùng thông thường
                    header('Location: /tlunews/public/user_dashboard.php');
                }
                exit();
            } else {
                // Hiển thị thông báo lỗi
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include APP_ROOT . '/app/views/auth/login.php';
            }
        } else {
            include APP_ROOT . '/app/views/auth/login.php'; // Hiển thị form login nếu chưa gửi POST
        }
    }

    // Xử lý đổi mật khẩu
    public function changePassword()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = htmlspecialchars($_POST['new_password']);
            $userId = $_SESSION['user']['id'];

            if ($this->authService->changePassword($userId, $newPassword)) {
                $success = "Đổi mật khẩu thành công.";
            } else {
                $error = "Có lỗi xảy ra, không thể đổi mật khẩu.";
            }
        }

        include APP_ROOT . '/app/views/auth/change_password.php'; // Hiển thị form đổi mật khẩu
    }

    // Xử lý đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /tlunews/public/login.php');
        exit();
    }
}
