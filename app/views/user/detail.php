<?php
require_once 'C:\laragon\www\Lab2_CSE485\app\controllers\NewController.php';

// Khởi tạo Controller
$controller = new NewController();

// Lấy danh sách danh mục
$categories = $controller->getCategories();

// Lấy ID danh mục từ URL
$selectedCategoryId = isset($_GET['id']) ? intval($_GET['id']) : null;

// Lấy tin tức được lọc theo danh mục
$filteredNews = $controller->getFilteredNews($selectedCategoryId);

// Phân trang
$recordsPerPage = 5;
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$paginationResult = $controller->paginate($filteredNews, $currentPage, $recordsPerPage);
$paginatedNews = $paginationResult['data'];
$totalPages = $paginationResult['totalPages'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS dành riêng cho bảng 1 */
        .table-1 th:nth-child(1), .table-1 td:nth-child(1) {
            width: 10%;
            text-align: center;
        }
        .table-1 th:nth-child(2), .table-1 td:nth-child(2) {
            width: 50%;
            text-align: left;
        }
        .table-1 th:nth-child(3), .table-1 td:nth-child(3) {
            width: 40%;
            text-align: center;
        }

        /* CSS dành riêng cho bảng 2 */
        .table-2 th:nth-child(1), .table-2 td:nth-child(1) {
            width: 3%;
            text-align: center;
        }
        .table-2 th:nth-child(2), .table-2 td:nth-child(2) {
            width: 10%;
            text-align: left;
        }
        .table-2 th:nth-child(3), .table-2 td:nth-child(3) {
            width: 20%;
            text-align: left;
        }
        .table-2 th:nth-child(4), .table-2 td:nth-child(4) {
            width: 15%;
            text-align: center;
        }
        .table-2 th:nth-child(5), .table-2 td:nth-child(5) {
            width: 15%;
            text-align: center;
        }
        .table-2 th:nth-child(6), .table-2 td:nth-child(6) {
            width: 11%;
            text-align: center;
        }

        .table-2 td img {
            width: 150px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Thanh cuộn chỉ cho phần dữ liệu bảng 1 */
        .table-wrapper-1 .table-data {
            max-height: 300px;
            overflow-y: auto;
        }
        .table-wrapper-1 .table-data::-webkit-scrollbar {
            width: 8px;
        }
        .table-wrapper-1 .table-data::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .table-wrapper-1 .table-data::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .table-container {
            display: flex;
            gap: 20px;
        }
        .table-wrapper:first-child {
            flex: 0.25;
        }
        .table-wrapper:last-child {
            flex: 0.75;
        }
        .table-wrapper h3 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4 text-center"><b>Quản Lý Danh Mục</b></h1>

    <div class="table-container">
        <!-- Bảng 1: Danh sách danh mục -->
        <div class="table-wrapper table-wrapper-1">
            <h2>Danh Sách Danh Mục</h2>
            <table class="table table-bordered table-striped table-1">
                <thead>
                <tr>
                    <th>ID</th>
                    <th class="text-center">Name</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
            </table>
            <div class="table-data">
                <table class="table table-bordered table-striped table-1">
                    <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['id']); ?></td>
                                <td><?php echo htmlspecialchars($category['name']); ?></td>
                                <td>
                                    <a href="?id=<?php echo $category['id']; ?>" class="btn btn-info btn-sm">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Không có danh mục nào trong cơ sở dữ liệu.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng 2: Hiển thị tin tức -->
        <div class="table-wrapper table-wrapper-2">
            <h2 class="text-center">Hiển Thị Thông Tin</h2>
            <?php if ($selectedCategoryId !== null): ?>
                <h5>Danh mục ID: <?php echo $selectedCategoryId; ?></h5>
            <?php endif; ?>
            <table class="table table-bordered table-striped table-2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Category ID</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($paginatedNews)): ?>
                    <?php foreach ($paginatedNews as $newsItem): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($newsItem['id']); ?></td>
                            <td><?php echo htmlspecialchars($newsItem['title']); ?></td>
                            <td><?php echo htmlspecialchars($newsItem['content']); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($newsItem['image']); ?>" alt="Image">
                            </td>
                            <td><?php echo htmlspecialchars($newsItem['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($newsItem['category_id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có tin tức cho danh mục này.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?id=<?php echo $selectedCategoryId; ?>&page=<?php echo $currentPage - 1; ?>">Trước</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?id=<?php echo $selectedCategoryId; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?id=<?php echo $selectedCategoryId; ?>&page=<?php echo $currentPage + 1; ?>">Sau</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
