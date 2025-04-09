<?php

namespace src\models;

use src\repository\Database;

use PDO;

class User {
    private PDO $pdo;
    public function __construct() {
        $this->pdo = Database::connect();
    }
    public function getFiltered($filter_name, $filter_role):array{
        $sqlstat="SELECT * FROM users WHERE 1=1 ";
        $params=[];
        if ($filter_name !== ""){
            $sqlstat .= "AND user_name=:name ";
            $params[":name"]=$filter_name;
        }
        if ($filter_role !== ""){
            $sqlstat .= "AND user_role=:role ";
            $params[":role"]=$filter_role;
        }
        $stmt = $this->pdo->prepare($sqlstat);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $user_name, string $user_email, string $user_password, string $user_role): bool {
        $stmt = $this->pdo->prepare("INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (:user_name, :user_email, :user_password, :user_role)");
        $success = $stmt->execute([
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_password' => password_hash($user_password, PASSWORD_DEFAULT),
            'user_role' => $user_role,
        ]);
        return $success;
    }

    public function authUser($user_email, string $user_password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_email = :user_email");
        $stmt->execute(['user_email' => $user_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($user);
        if (!$user || !password_verify($user_password, $user['user_password'])) {
            return false;
        }
        return $user;
    }
}
?>