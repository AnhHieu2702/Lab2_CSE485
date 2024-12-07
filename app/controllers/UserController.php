// app/controllers/UserController.php
<?php

class UserController
{
    // Lấy tất cả người dùng
    public function index()
    {
        $users = Users::getAllUsers(); // Trực tiếp gọi model để lấy dữ liệu người dùng
        // Chuyển dữ liệu thành JSON để hiển thị hoặc xử lý
        echo json_encode($users);
    }

    // Lấy người dùng theo tên đăng nhập
    public function show($username)
    {
        $user = Users::getUserByUsername($username);
        echo json_encode($user); // Trả về thông tin người dùng dưới dạng JSON
    }

    // Tạo người dùng mới
    public function create($username, $password, $role)
    {
        $user = Users::createUser($username, $password, $role); // Gọi trực tiếp model để tạo người dùng
        if ($user) {
            echo "User created successfully: " . json_encode($user);
        } else {
            echo "Error creating user";
        }
    }

    // Cập nhật thông tin người dùng
    public function update($id, $username, $password, $role)
    {
        $user = Users::updateUser($id, $username, $password, $role); // Gọi trực tiếp model để cập nhật người dùng
        if ($user) {
            echo "User updated successfully: " . json_encode($user);
        } else {
            echo "Error updating user";
        }
    }

    // Xóa người dùng theo id
    public function delete($id)
    {
        $result = Users::deleteUser($id); // Gọi trực tiếp model để xóa người dùng
        echo $result ? "User deleted successfully" : "Error deleting user";
    }
}
