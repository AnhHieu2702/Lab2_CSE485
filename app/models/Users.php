<?php
require_once 'D:\laragon\www\Lab2_CSE485\app\config\database.php';

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Lấy tất cả người dùng với phân trang
    public function getAllUsers($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare("SELECT id, username, password, role FROM users LIMIT :offset, :perPage");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số người dùng để tính toán phân trang
    public function getUserCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Tạo người dùng mới
    public function createUser($username, $password, $role)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);  // Không mã hóa mật khẩu
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $username, $password, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);  // Không mã hóa mật khẩu
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    // Xóa người dùng
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT id, username, password, role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
