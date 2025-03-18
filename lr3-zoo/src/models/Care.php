<?php

namespace src\models;

use src\repository\Database;

use PDO;

class Care{
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::connect();
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM care");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addCare(string $care_type, string $animal_name): void {
        $stmt = $this->pdo->prepare("INSERT INTO care (care_type, animal_name) VALUES (:care_type, :animal_name)");
        $stmt->execute([
            'care_type' => $care_type,
            'animal_name' => $animal_name,
        ]);
    }
}

?>