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

    public function getFiltered($filter_gender,$filter_name):array{
        $sqlstat="SELECT * FROM animals,care WHERE animals.animal_name=care.animal_name AND 1=1 ";
        $params=[];
        if ($filter_name !== ""){
            $sqlstat .= "AND animal_name=:name ";
            $params[":name"]=$filter_name;
        }
        if ($filter_gender !== ""){
            $sqlstat .= "AND animal_gender=:gender ";
            $params[":gender"]=$filter_gender;
        }
        $stmt = $this->pdo->prepare($sqlstat);
        $stmt->execute($params);
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
    public function updateAnimal(int $animal_id, string $animal_name, string $animal_gender, int $animal_age, int $animal_cage): bool {
        $stmt = $this->pdo->prepare("UPDATE animals 
        SET animal_name = :name,
        animal_gender = :gender,
        animal_age = :age,
        animal_cage = :cage
        WHERE animal_id=:id");
        $success = $stmt->execute([
            ':id' => $animal_id,
            ':name' => $animal_name,
            ':gender' => $animal_gender,
            ':age' => $animal_age,
            ':cage' => $animal_cage,
        ]);
        return $success;
    }
    public function import(string $path): bool{
        $file = fopen($path,"r");
        if ($file){
            while (($row = fgetcsv($file,1000,","))!=false) {
                $stmt = $this->pdo->prepare("INSERT INTO animals (animal_name,animal_gender,animal_age,animal_cage) VALUES(?, ?, ?, ?)");
                $stmt->execute([$row[0],$row[1],$row[2],$row[3]]);
            }
            fclose($file);
            return true;
        }
        return false;
    }
}