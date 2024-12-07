<?php
require_once 'services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    // Hiển thị danh sách người dùng với phân trang
    public function index() {
        // Lấy giá trị của 'page' từ URL, mặc định là 1 nếu không có
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

        // Đảm bảo trang luôn là số nguyên dương, tối thiểu là 1
        $page = ($page < 1) ? 1 : $page;

        // Giả sử bạn đã có số bản ghi mỗi trang
        $recordsPerPage = 10;

        // Lấy tổng số bản ghi từ cơ sở dữ liệu
        $totalRecords = $this->getTotalRecords();

        // Tính tổng số trang
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Đảm bảo rằng $page không lớn hơn số trang tối đa
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        // Tính toán offset (vị trí bắt đầu) cho truy vấn cơ sở dữ liệu
        $offset = ($page - 1) * $recordsPerPage;

        // Lấy dữ liệu người dùng cho trang hiện tại
        $users = $this->getUsers($offset, $recordsPerPage);

        // Truyền dữ liệu vào view
        include 'views/dashboard/admin.php';
    }

    // Hàm lấy tổng số bản ghi (người dùng) trong cơ sở dữ liệu
    private function getTotalRecords() {
        // Lấy kết nối database
        $db = Database::getInstance();
        $conn = $db->getConnection();

        // Truy vấn lấy tổng số người dùng
        $stmt = $conn->query('SELECT COUNT(*) FROM users');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'];
    }

    // Hàm lấy dữ liệu người dùng cho phân trang
    private function getUsers($offset, $limit) {
        // Lấy kết nối database
        $db = Database::getInstance();
        $conn = $db->getConnection();

        // Truy vấn lấy dữ liệu người dùng theo offset và limit
        $stmt = $conn->prepare('SELECT * FROM users LIMIT :offset, :limit');
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        // Trả về kết quả truy vấn
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Thêm người dùng mới
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            if ($this->userService->createUser($username, $password, $role)) {
                header('Location: index.php?action=index');  // Chuyển hướng về trang index
                exit();
            } else {
                $_SESSION['error'] = 'Thêm người dùng không thành công.';
                header('Location: index.php?action=index');  // Redirect back to the users list page
                exit();
            }
        }
    }

    // Cập nhật người dùng
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            if ($this->userService->updateUser($id, $username, $password, $role)) {
                header('Location: index.php?action=index');  // Redirect to users list
                exit();
            } else {
                $_SESSION['error'] = 'Cập nhật người dùng không thành công.';
                header('Location: index.php?action=index');  // Redirect back to users list on error
                exit();
            }
        } else {
            echo "User ID is required for update.";
        }
    }

    // Xóa người dùng
    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if ($this->userService->deleteUser($id)) {
                header('Location: index.php?action=index');  // Redirect to users list after delete
                exit();
            } else {
                $_SESSION['error'] = 'Xóa người dùng không thành công.';
                header('Location: index.php?action=index');  // Redirect back to users list on error
                exit();
            }
        } else {
            echo "User ID is required for delete.";
        }
    }

    // Xem thông tin người dùng
    public function view($id)
    {
        $user = $this->userService->getUserById($id);
        require APP_ROOT . '/views/dashboard/admin.php';
    }
}

?>
