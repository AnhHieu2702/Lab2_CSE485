<?php
require_once 'C:\laragon\www\Lab2_CSE485\app\services\NewServices.php';

class NewController
{
    private $newServices;

    public function __construct()
    {
        $this->newServices = new NewServices();
    }

    public function getCategories()
    {
        return $this->newServices->getAllCategories();
    }

    public function getFilteredNews($selectedCategoryId)
    {
        $news = $this->newServices->getAllNews();
        if ($selectedCategoryId === null) {
            return $news;
        }

        // Lọc tin tức theo danh mục ID
        return array_filter($news, function ($newsItem) use ($selectedCategoryId) {
            return $newsItem['category_id'] == $selectedCategoryId;
        });
    }

    public function paginate($filteredNews, $currentPage, $recordsPerPage)
    {
        $totalRecords = count($filteredNews);
        $totalPages = ceil($totalRecords / $recordsPerPage);
        $startIndex = ($currentPage - 1) * $recordsPerPage;
        $paginatedNews = array_slice($filteredNews, $startIndex, $recordsPerPage);

        return [
            'data' => $paginatedNews,
            'totalPages' => $totalPages,
        ];
    }
}
?>
