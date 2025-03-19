<?php
    namespace src\controllers;

    use src\models\User;
    use src\services\validators\UserValidator;
    
    class UserController{
        private User $repository;
        public function __construct(){
            $this->repository = new User();
        }
        public function index(){
            $users = $this->repository->getAll();
            include __DIR__ . '/../views/tables/table_user.php';
        }
        public function form(){
            include __DIR__ . '/../views/forms/form_user.php';
        }
        public function create(){
            session_start();
            if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
                header("Location: /users/create");
                exit;
            }
            
            $message = UserValidator::validate($_POST);
            if ($message !==''){
                $_SESSION['message'] = $message;
                header('Location: /users/create');
                exit;
            }
            
            $user_name= trim($_POST['user-name']?? '');
            $user_email = trim($_POST['user-email']?? '');
            $user_password = trim($_POST['user-password']?? '');
            $user_role = trim($_POST['user-role']?? '');

            $success = $this->repository->addUser(
                $user_name,
                $user_email,
                $user_password,
                $user_role,
            );

            if ($success) {
                $_SESSION["message"] = "Пользователь успешно создан";
            } else {
                $_SESSION["message"] = "Невозможно создать пользователя";
            }
            
            header('Location: /users/create');
            exit;
        }
    }
?>