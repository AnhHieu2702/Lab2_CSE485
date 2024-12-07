<?php
require_once 'C:\laragon\www\Lab2_CSE485\app\config\database.php';

class NewServices
{
    private $db;

    public function __construct()
    {
        // Kết nối đến cơ sở dữ liệu
        $this->db = Database::getInstance()->getConnection();
    }

    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT id, name FROM categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Kiểm tra nếu có kết quả
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có dữ liệu
        }
    }

    // Lấy tất cả tin tức từ bảng 'news'
    public function getAllNews()
    {
        $sql = "SELECT id, title, content, image, created_at, category_id FROM news";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Kiểm tra nếu có kết quả
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có dữ liệu
        }
    }
}
?>
