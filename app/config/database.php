<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('\\', '/', dirname(dirname(__DIR__))));
}

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Tải cấu hình từ file config.php
        $config = require APP_ROOT . '/app/config/config.php';

        // Kiểm tra xem cấu hình database có đầy đủ không
        if (!isset($config['db']) || !isset($config['db']['host']) || !isset($config['db']['dbname']) || !isset($config['db']['username']) || !isset($config['db']['password'])) {
            die('Database configuration is missing or incomplete.');
        }

        $dbConfig = $config['db']; // Truy cập cấu hình database

        try {
            // Kết nối đến cơ sở dữ liệu
            $this->connection = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}",
                $dbConfig['username'],
                $dbConfig['password']
            );
            // Thiết lập chế độ báo lỗi
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Nếu kết nối không thành công, ghi log lỗi và dừng script
            error_log('Database connection error: ' . $e->getMessage());
            die('Database connection failed.');
        }
    }

    // Singleton pattern: Chỉ tạo một kết nối duy nhất
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Trả về kết nối database
    public function getConnection()
    {
        return $this->connection;
    }
}

