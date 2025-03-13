<?php
namespace APP\models;

use App\core\Database;
use PDO;

class User {
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::connect();
    }

    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM Users");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $name, string $email, int $age): void{
        $stmt = $this->pdo->prepare("INSERT INTO Users (name,email,age) VALUES(:name, :email,:age)");
        $stmt->execute([
            'name' => htmlspecialchars($name),
            'email'=> filter_var($email, FILTER_SANITIZE_EMAIL),
            'age' => $age,
        ]);
    }
}

?>