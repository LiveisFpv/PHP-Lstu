<?php
    namespace src\controllers;
    
    use src\models\Animal;
    use src\services\validators\AnimalValidator;
    use src\lib\files\Files;

    class AnimalController{
        private Animal $repository;
        public function __construct() {
            $this->repository = new Animal();
        }
        public function index() {
            $animals = $this->repository->getAll();
            include __DIR__ . '/../views/tables/table_animal.php';
        }
        public function form(){
            include __DIR__ . '/../views/forms/form_animal.php';
        }
        public function create() {
            session_start();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /animals/create");
                exit;
            }
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];

                Files::save($file);

                $this->import(__DIR__ ."/../uploads/data.csv");

                header("Location: /animals/create");
                exit;
            }
            $message = AnimalValidator::validate($_POST);
    
            if ($message!=='') {
                $_SESSION["message"] = $message;
                header("Location: /animals/create");
                exit;
            }
            
            $animal_name = trim($_POST['animal-name']?? '');
            $animal_gender = trim($_POST['animal-gender']?? '');
            $animal_age = trim($_POST['animal-age']?? '');
            $animal_cage = trim($_POST['cage']?? '');

            $success = $this->repository->addAnimal(
                $animal_name,
                $animal_gender,
                (int)$animal_age,
                (int)$animal_cage,
            );
    
            if ($success) {
                $_SESSION["message"] = "Животное успешно добавлено!";
            } else {
                $_SESSION["message"] = "Ошибка при добавлении в базу данных.";
            }
    
            header("Location: /animals/create");
            exit;
        }
        public function import($path){
            $this->repository->import($path);
            $_SESSION["message"] = "Данные считаны";
            header("Location: /animals/create");
            exit;
        }
    }
?>