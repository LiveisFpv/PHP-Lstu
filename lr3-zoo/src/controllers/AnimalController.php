<?php
    namespace src\controllers;
    
    use src\models\Animal;
    use src\services\validators\AnimalValidator;

    class AnimalController{
        private Animal $repository;
        public function __construct() {
            $this->repository = new Animal();
        }
        public function index() {
            $animals = $this->repository->getAll();
            include __DIR__ . '/../views/tables/table_animal.php';
        }
        public function create() {
            session_start();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /index.php");
                exit;
            }
    
            $message = AnimalValidator::validate($_POST);
    
            if (!empty($errors)) {
                $_SESSION["message"] = $message;
                header("Location: /index.php");
                exit;
            }
            
            $animal_name = trim($data['animal-name']?? '');
            $animal_gender = trim($data['animal-gender']?? '');
            $animal_age = trim($data['animal-age']?? '');
            $animal_cage = trim($data['cage']?? '');

            $success = $this->repository->addAnimal(
                $animal_name,
                $animal_gender,
                $animal_age,
                $animal_cage,
            );
    
            if ($success) {
                $_SESSION["message"] = "Животное успешно добавлено!";
            } else {
                $_SESSION["message"] = "Ошибка при добавлении в базу данных.";
            }
    
            header("Location: /index.php");
            exit;
        }
    }
?>