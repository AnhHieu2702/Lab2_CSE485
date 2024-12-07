<?php
require_once 'C:\xampp\htdocs\Lab2_CSE485-vuong1\Lab2_CSE485-vuong1\app\models\News.php';

class NewsController {
    public static function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $limit = 5; // Số bản ghi mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'add') {
                $news = new News(null, $_POST['title'], $_POST['content'], $_POST['image'], date('Y-m-d H:i:s'), $_POST['category_id']);
                $news->save();
                header('Location: admin.php');
                exit();
            } elseif ($action === 'edit') {
                $news = new News($_POST['id'], $_POST['title'], $_POST['content'], $_POST['image'], date('Y-m-d H:i:s'), $_POST['category_id']);
                $news->update();
                header('Location: admin.php');
                exit();
            }
        } elseif ($action === 'delete' && isset($_GET['delete_id'])) {
            $news = new News($_GET['delete_id'], null, null, null, null, null);
            $news->delete();
            header('Location: admin.php');
            exit();
        }

        $newsList = News::getAll($limit, $offset);
        $totalRecords = News::countAll();
        $totalPages = ceil($totalRecords / $limit);

        $currentNews = null;
        if ($action === 'edit' && isset($_GET['id'])) {
            $currentNews = News::getById($_GET['id']);
        }
        $newsDetail = null;
        if ($action === 'view' && isset($_GET['id'])) {
            $id =(int) $_GET['id'];
            $newsDetail = News::getById($_GET['id']);
        }

        return [
            'action' => $action,
            'newsList' => $newsList,
            'totalRecords' => $totalRecords,
            'totalPages' => $totalPages,
            'currentNews' => $currentNews,
            'newsDetail' => $newsDetail,
            'currentPage' => $page,
        ];
    }
}
?>
