<?php

namespace src\models;

use src\repository\Database;

use PDO;

class Animal{
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::connect();
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM animals");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addAnimal(string $animal_name, string $animal_gender, int $animal_age, int $animal_cage): void {
        $stmt = $this->pdo->prepare("INSERT INTO animals (animal_name, animal_gender, animal_age, animal_cage) VALUES (:name, :gender, :age, :cage)");
        $stmt->execute([
            ':name' => $animal_name,
            ':gender' => $animal_gender,
            ':age' => $animal_age,
            ':cage' => $animal_cage,
        ]);
    }
}