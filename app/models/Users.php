<?php
class Users
{
    private $id;
    private $username;
    private $password;
    private $role;
    

    public function __construct($id, $password, $role, $username)
    {
        
        $this->id = $id;
        $this->password = $password;
        $this->role = $role;
        $this->username = $username;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
    // Lấy tất cả người dùng từ cơ sở dữ liệu
    public static function getAllUsers()
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tạo mảng các đối tượng Users
        $users = [];
        foreach ($usersData as $userData) {
            $users[] = new self($userData['id'], $userData['username'], $userData['password'], $userData['role']);
        }
        return $users;
    }

    // Lấy người dùng theo tên đăng nhập
    public static function getUserByUsername($username)
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new self($userData['id'], $userData['username'], $userData['password'], $userData['role']);
        }
        return null; // Nếu không tìm thấy người dùng, trả về null
    }

    // Tạo người dùng mới
    public static function createUser($username, $password, $role)
    {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Mã hóa mật khẩu
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return new self($db->lastInsertId(), $username, $password, $role); // Trả về đối tượng User mới tạo
        }
        return null; // Nếu không thể tạo người dùng, trả về null
    }

    // Cập nhật thông tin người dùng
    public static function updateUser($id, $username, $password, $role)
    {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Mã hóa mật khẩu
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return new self($id, $username, $password, $role); // Trả về đối tượng User đã cập nhật
        }
        return null; // Nếu không thể cập nhật, trả về null
    }

    // Xóa người dùng theo id
    public static function deleteUser($id)
    {
        $db = Database::getInstance()->getConnection();
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // Trả về kết quả của việc xóa
    }
}