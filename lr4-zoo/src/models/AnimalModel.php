<?php
class AnimalModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllAnimals() {
        $query = "SELECT * FROM animals";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalById($id) {
        $query = "SELECT * FROM animals WHERE animal_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addAnimal($data) {
        $query = "INSERT INTO animals (animal_name, animal_gender, animal_age, animal_cage, animal_care) 
                  VALUES (:name, :gender, :age, :cage, :care)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':name' => $data['name'],
            ':gender' => $data['gender'],
            ':age' => $data['age'],
            ':cage' => $data['cage'],
            ':care' => $data['care']
        ]);
        return $this->db->lastInsertId();
    }

    public function updateAnimal($id, $data) {
        $query = "UPDATE animals SET 
                  animal_name = :name, 
                  animal_gender = :gender, 
                  animal_age = :age, 
                  animal_cage = :cage, 
                  animal_care = :care 
                  WHERE animal_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':name' => $data['name'],
            ':gender' => $data['gender'],
            ':age' => $data['age'],
            ':cage' => $data['cage'],
            ':care' => $data['care'],
            ':id' => $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteAnimal($id) {
        $query = "DELETE FROM animals WHERE animal_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>