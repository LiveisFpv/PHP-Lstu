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
    public function addAnimal(string $animal_name, string $animal_gender, int $animal_age, int $animal_cage): bool {
        $stmt = $this->pdo->prepare("INSERT INTO animals (animal_name, animal_gender, animal_age, animal_cage) VALUES (:name, :gender, :age, :cage)");
        $success = $stmt->execute([
            ':name' => $animal_name,
            ':gender' => $animal_gender,
            ':age' => $animal_age,
            ':cage' => $animal_cage,
        ]);
        return $success;
    }
    public function import(string $path): void{
        $file = fopen($path,"r");
        while (($row = fgetcsv($file,1000,","))!=false) {
            $stmt = $this->pdo->prepare("INSERT INTO animals (animal_name,animal_gender,animal_age,animal_cage) VALUES(?, ?, ?, ?)");
            $stmt->execute([$row[0],$row[1],$row[2],$row[3]]);
        }
        fclose($file);
    }
}