<?php
require_once 'C:\laragon\www\tlunews\app\config\database.php';

$db = Database::getInstance()->getConnection();

// Truy vấn để lấy dữ liệu người dùng
$stmt = $db->prepare("SELECT id, title, content, image, created_at FROM news");
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
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Created_at</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['content']) ?></td>
                    <td><?= htmlspecialchars($row['image']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
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