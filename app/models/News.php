<?php
    require_once('C:\xampp\htdocs\Lab2_CSE485-vuong1\Lab2_CSE485-vuong1\app\config\database.php');
class News
{
    private $id;
    private $title;
    private $content;
    private $image;
    private $created_at;
    private $category_id;

    private $db; // Biến để kết nối cơ sở dữ liệu

    public function __construct($id = null, $title = null, $content = null, $image = null, $created_at = null, $category_id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->category_id = $category_id;

        // Kết nối cơ sở dữ liệu
        $this->db = Database::getInstance()->getConnection();
    }

    // Các getter và setter
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; return $this; }
    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; return $this; }
    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; return $this; }
    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; return $this; }
    public function getCategoryId() { return $this->category_id; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; return $this; }

    public function save()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO news (title, content, image, created_at, category_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $this->created_at,
            $this->category_id
        ]);
    }

    // Thêm mới tin tức

    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO news (title, content, image, created_at, category_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            date('Y-m-d H:i:s'), 
            $this->category_id
        ]);
    }

    // Cập nhật tin tức
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE news SET title = ?, content = ?, image = ?, category_id = ? WHERE id = ?");
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $this->category_id,
            $this->id
        ]);
    }
    public function delete()
    {
        $stmt = $this->db->prepare("DELETE FROM news WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
    public static function getAll($limit, $offset)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM news ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function countAll()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM news");
        return $stmt->fetchColumn();
    }
}
