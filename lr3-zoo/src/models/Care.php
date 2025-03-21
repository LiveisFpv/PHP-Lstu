<?php

namespace src\models;

use src\repository\Database;

use PDO;

class Care{
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::connect();
    }
    public function getFiltered($filter_name):array{
        $sqlstat="SELECT * FROM care WHERE 1=1 ";
        $params=[];
        if ($filter_name !== ""){
            $sqlstat .= "AND animal_name=:name ";
            $params[":name"]=$filter_name;
        }
        $stmt = $this->pdo->prepare($sqlstat);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM care");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addCare(string $care_type, string $animal_name): bool {
        $stmt = $this->pdo->prepare("INSERT INTO care (care_type, animal_name) VALUES (:care_type, :animal_name)");
        $success=$stmt->execute([
            'care_type' => $care_type,
            'animal_name' => $animal_name,
        ]);
        return $success;
    }
}

?>