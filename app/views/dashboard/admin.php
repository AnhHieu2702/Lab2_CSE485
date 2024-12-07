<?php
require_once 'D:\laragon\www\Lab2_CSE485\app\config\database.php';

$db = Database::getInstance()->getConnection();

// Truy vấn để lấy dữ liệu người dùng
$stmt = $db->prepare("SELECT id, username, password, role FROM users");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Ẩn bảng ban đầu */
        #userManagement {
            display: none;
        }
    </style>
</head>
<body>
<div class="container mt-3">
    <h2>Xin chào quản lý!</h2>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark rounded mb-3">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a id="manageUsersLink" class="nav-link" href="javascript:void(0)">Quản lý người dùng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">Quản lý danh mục</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Id">
                    <input class="form-control me-2" type="text" placeholder="Name">
                    <button class="btn btn-primary me-2" type="button">Search</button>
                    <button class="btn btn-primary" type="button">Add</button>

                </form>
            </div>
        </div>
    </nav>
<!-- Bảng quản lý người dùng -->
<div id="userManagement" class="my-5">
        <h1 class="mb-4">Quản lý Người Dùng</h1>
        <a href="index.php?action=create" data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary mb-3">Thêm mới</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['password']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td>
                            <a href="index.php?action=view&id=<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                            <a href="index.php?action=update&id=<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="index.php?action=delete&id=<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- Modal xem thông tin người dùng -->
<?php foreach ($data as $row): ?>
    <div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <?= htmlspecialchars($row['username']) ?></p>
                    <p><strong>Password:</strong> <?= htmlspecialchars($row['password']) ?></p>
                    <p><strong>Role:</strong> <?= htmlspecialchars($row['role']) ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<!-- Modal Thêm người dùng -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?action=create&page=<?= $_GET['page'] ?? 1 ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal xóa người dùng -->
<?php foreach ($data as $row): ?>
    <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa người dùng này?</p>
                </div>
                <div class="modal-footer">
                    <form action="../public/index.php?action=delete&id=<?= $row['id'] ?>&page=<?= $_GET['page'] ?? 1 ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal sửa thông tin người dùng -->
<?php foreach ($data as $row): ?>
    <div class="modal fade" id="updateModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Sửa thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../public/index.php?action=update&id=<?= $row['id'] ?>&page=<?= $_GET['page'] ?? 1 ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($row['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($row['password']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($row['role']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    
<!--phân trang -->  
<?php
// Lấy giá trị trang từ URL
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Giả sử tổng số bản ghi và số bản ghi mỗi trang
$totalRecords = 100; // Số bản ghi thực tế
$recordsPerPage = 10; // Số bản ghi mỗi trang
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- Nút Previous -->
        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?action=index&page=<?= $page - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        
        <!-- Các số trang -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?action=index&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Nút Next -->
        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?action=index&page=<?= $page + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>



</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Khi nhấn vào "Quản lý người dùng", hiển thị bảng quản lý
    document.getElementById('manageUsersLink').addEventListener('click', function () {
        document.getElementById('userManagement').style.display = 'block';
    });
</script>
</body>
</html>

