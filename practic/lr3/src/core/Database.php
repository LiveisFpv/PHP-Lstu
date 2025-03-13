<?php

namespace App\core;
use PDO;
use PDOException;

class Database{
    private static ?PDO $pdo = null;
    public static function connect(): PDO{
        if(self::$pdo === null){
            $config = parse_ini_file(__DIR__ ."/../../.env");
            try{
                self::$pdo = new PDO("mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset=utf8",
                $config["DB_USER"],
                $config["DB_PASS"],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            } catch(PDOException $e){
                die ("Ошибся но где". $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

?>