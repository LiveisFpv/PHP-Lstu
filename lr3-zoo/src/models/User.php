<?php

namespace src\models;

use src\repository\Database;

use PDO;

class User {
    private PDO $pdo;
    public function __construct() {
        $this->pdo = Database::connect();
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $user_name, string $user_email, string $user_password, string $user_role): void {
        $stmt = $this->pdo->prepare("INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (:user_name, :user_email, :user_password, :user_role)");
        $stmt->execute([
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_password' => password_hash($user_password, PASSWORD_DEFAULT),
            'user_role' => $user_role,
        ]);
    }
}
?>