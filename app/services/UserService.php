<?php
require_once 'models/User.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Users();
    }

    // Lấy tất cả người dùng với phân trang
    public function getAllUsers($page, $perPage)
    {
        return $this->userModel->getAllUsers($page, $perPage);
    }

    // Lấy tổng số người dùng để tính toán phân trang
    public function getUserCount()
    {
        return $this->userModel->getUserCount();
    }

    // Thêm người dùng mới
    public function createUser($username, $password, $role)
{
    global $db;

    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
}


    // Cập nhật người dùng
    public function updateUser($id, $username, $password, $role)
{
    global $db;

    $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
    $stmt->execute([$username, $password, $role, $id]);
}


    // Xóa người dùng
    public function deleteUser($id)
{
    global $db;

    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}


    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        return $this->userModel->getUserById($id);
    }
}
?>
