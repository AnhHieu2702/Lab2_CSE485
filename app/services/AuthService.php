<?php

require_once __DIR__ . '/../config/database.php';

class AuthService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Xác thực đăng nhập
    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
        }

        return null; // Đăng nhập thất bại
    }

    // Đổi mật khẩu
    public function changePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        return $stmt->execute(); // Trả về true nếu thành công, false nếu thất bại
    }
}


