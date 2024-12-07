<?php
require_once 'C:\xampp\htdocs\Lab2_CSE485-vuong1\Lab2_CSE485-vuong1\app\controllers\NewController.php';

$data = NewsController::handleRequest();
$action = $data['action'];
$newsList = $data['newsList'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$currentNews = $data['currentNews'];
$newsDetail = $data['newsDetail'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3">
<h2>Xin chào quản lý!</h2>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark rounded mb-3">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">Quản lý người dùng</a>
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

    <?php if ($action === 'list'): ?>
        <h2>Quản lý Danh Mục</h2>
        <a href="admin.php?action=add" class="btn btn-primary mb-3">Thêm mới</a>
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Hình ảnh</th>
                <th>ID Danh mục</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($newsList as $news): ?>
                <tr>
                    <td><?= htmlspecialchars($news['id']) ?></td>
                    <td><?= htmlspecialchars($news['title']) ?></td>
                    <td><?= htmlspecialchars($news['content']) ?></td>
                    <td><img src="<?= htmlspecialchars($news['image']) ?>" style="width: 50px; height: 50px;"></td>
                    <td><?= htmlspecialchars($news['category_id']) ?></td>
                    <td><?= htmlspecialchars($news['created_at']) ?></td>
                    <td>
                        <a href="admin.php?action=view&id=<?= $news['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                        <a href="admin.php?action=edit&id=<?= $news['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="admin.php?action=delete&delete_id=<?= $news['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="admin.php?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="admin.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="admin.php?page=<?= $currentPage + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    <?php elseif ($action === 'add'): ?>
        <h3>Thêm tin tức</h3>
        <form method="POST" action="admin.php?action=add">
            <div class="mb-3">
                <label>Tiêu đề:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nội dung:</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Hình ảnh:</label>
                <input type="text" name="image" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>ID Danh mục:</label>
                <input type="number" name="category_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
        </form>
    <?php elseif ($action === 'edit' && $currentNews): ?>
        <h3>Sửa tin tức</h3>
        <form method="POST" action="admin.php?action=edit">
            <input type="hidden" name="id" value="<?= $currentNews['id'] ?>">
            <div class="mb-3">
                <label>Tiêu đề:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($currentNews['title']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nội dung:</label>
                <textarea name="content" class="form-control" required><?= htmlspecialchars($currentNews['content']) ?></textarea>
            </div>
            <div class="mb-3">
                <label>Hình ảnh:</label>
                <input type="text" name="image" value="<?= htmlspecialchars($currentNews['image']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>ID Danh mục:</label>
                <input type="number" name="category_id" value="<?= htmlspecialchars($currentNews['category_id']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Cập nhật</button>
            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
        </form>
    <?php endif; ?>
    <?php if ($action === 'view'): ?>
    <?php if ($newsDetail): ?>
        <h3>Chi tiết tin tức</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($newsDetail['id']) ?></td>
            </tr>
            <tr>
                <th>Tiêu đề</th>
                <td><?= htmlspecialchars($newsDetail['title']) ?></td>
            </tr>
            <tr>
                <th>Nội dung</th>
                <td><?= nl2br(htmlspecialchars($newsDetail['content'])) ?></td>
            </tr>
            <tr>
                <th>Hình ảnh</th>
                <td><img src="<?= htmlspecialchars($newsDetail['image']) ?>" alt="Image" style="width: 100px; height: 100px;"></td>
            </tr>
            <tr>
                <th>ID Danh mục</th>
                <td><?= htmlspecialchars($newsDetail['category_id']) ?></td>
            </tr>
            <tr>
                <th>Ngày tạo</th>
                <td><?= htmlspecialchars($newsDetail['created_at']) ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Không tìm thấy chi tiết tin tức.</p>
    <?php endif; ?>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
