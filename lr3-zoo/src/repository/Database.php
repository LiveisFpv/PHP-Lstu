<?php
namespace src\repository;

// Подключает класс PDO для работы с базой данных
use PDO;

// Подключает класс PDOException для обработки ошибок подключения
use PDOException;

class Database {
    private static ?PDO $pdo = null;
    
    private static $host = 'db';
    private static $db_name = 'my_database';
    private static $username = 'root';
    private static $password = 'root';

    public static function connect(): PDO {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$db_name, self::$username, self::$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                self::$pdo->exec("set names utf8");
            } catch (PDOException $exception) {
                die("Ошибка подключения к базе данных: " . $exception->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>