<?php
    namespace src\controllers;

    use src\models\Care;
    use src\services\validators\CareValidator;

    class CareController{
        private Care $repository;
        public function __construct() {
            $this->repository = new Care();
        }
        public function index(){
            $cares = $this->repository->getAll();
            include __DIR__ . '/../views/tables/table_care.php';
        }
        public function form(){
            include __DIR__ . '/../views/forms/form_care.php';
        }
        public function create(){
            session_start();
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /cares/create");
                exit;
                // $care_type = trim($_POST['care-type']?? '');
                // $animal_name = trim($_POST['animal-name'] ?? '');
            }
            $message = CareValidator::validate($_POST);

            // if(empty($care_type)){
            //     $error = true;
            //     $message = $message . "Тип ухода не может быть пустым.\n";
            // }
            // elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $care_type)) {
            //     $error = true;
            //     $message = $message . "Тип ухода может содержать только буквы, пробелы и дефисы.\n";
            // }
            // if(empty($animal_name)){
            //     $error = true;
            //     $message = $message . "Название животного не может быть пустым.\n";
            // }
            // elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $animal_name)) {
            //     $error = true;
            //     $message = $message . "Название животного может содержать только буквы, пробелы и дефисы.\n";
            // }

            if (!$message!=='') {
                $_SESSION["message"] = $message;
                header("Location: /cares/create");
                exit;
            }
            $care_type = trim($_POST['care-type']?? '');
            $animal_name = trim($_POST['animal-name'] ?? '');

            $success = $this->repository->addCare($care_type,$animal_name);

            if ($success) {
                $_SESSION["message"] = "Уход успешно добавлен!";
            } else {
                $_SESSION["message"] = "Ошибка при добавлении в базу данных.";
            }
            header('Location: /cares/create');
            exit;
        }
    }
?>