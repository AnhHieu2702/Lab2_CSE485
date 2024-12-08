<?php

require_once __DIR__ . '/../config/database.php';

class AuthService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
        }

        return null;
    }

    // Đổi mật khẩu
    public function changePassword($userId, $currentPassword, $newPassword)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id AND password = :currentPassword");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':currentPassword', $currentPassword, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false; // Mật khẩu cũ không khớp
            }

            // Cập nhật mật khẩu mới
            $stmt = $this->db->prepare("UPDATE users SET password = :newPassword WHERE id = :id");
            $stmt->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

            return $stmt->execute(); // Trả về true nếu thành công
        } catch (PDOException $e) {
            error_log("Password change error: " . $e->getMessage());
            return false;
        }
    }
}
