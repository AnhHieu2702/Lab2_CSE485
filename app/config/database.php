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
        $config = require APP_ROOT . '/app/config/config.php';
        if (!isset($config['db']) || !isset($config['db']['host']) || !isset($config['db']['dbname']) || !isset($config['db']['username']) || !isset($config['db']['password'])) {
            die('Database configuration is missing or incomplete.');
        }

        $dbConfig = $config['db'];

        try {
            $this->connection = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}",
                $dbConfig['username'],
                $dbConfig['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            die('Database connection failed.');
        }
    }

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

