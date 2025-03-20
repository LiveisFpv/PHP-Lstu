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
            }
            $message = CareValidator::validate($_POST);
            if ($message!=='') {
                $_SESSION["message"] = $message;
                header("Location: /cares/create");
                exit;
            }
            $care_type = trim($_POST['care-type']?? '');
            $animal_name = trim($_POST['animal-name'] ?? '');

            $success = $this->repository->addCare(
                $care_type,
                $animal_name,
            );

            if ($success) {
                $_SESSION["message"] = "Уход успешно добавлен!";
            } else {
                $_SESSION["message"] = "Ошибка при добавлении в базу данных.";
            }
            header("Location: /cares/create");
            exit;
        }
    }
?>