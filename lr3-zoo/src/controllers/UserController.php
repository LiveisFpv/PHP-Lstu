<?php
    namespace src\controllers;

    use src\models\User;
    use src\services\validators\UserValidator;
    
    use Twig\Environment;

    use Twig\Loader\FilesystemLoader;

    class UserController{
        private User $repository;

        private Environment $twig;
        public function __construct(){
            $this->repository = new User();
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader);
        }
        public function index(){
            $filter_name=trim($_GET["filter_name"] ?? "");
            $filter_role=trim($_GET["filter_role"] ?? "");
            $users = $this->repository->getFiltered($filter_name,$filter_role);
            echo $this->twig->render('tables/table_user.twig',
            ['users' => $users,
            'selected_name' => $filter_name,
            'selected_role' => $filter_role,
            ]);
        }
        public function form(){
            include __DIR__ . '/../views/forms/form_user.php';
        }
        public function auth_index(){
            include __DIR__ . '/../views/forms/form_auth.php';
        }
        public function auth(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
                header("Location: /users/auth");
                exit;
            }
            $message = UserValidator::validate_auth($_POST);
            if ($message !==''){
                $_SESSION['message'] = $message;
                header('Location: /users/auth');
                exit;
            }

            $user_email = trim($_POST['user-email']?? '');
            $user_password = trim($_POST['user-password']?? '');

            $user = $this->repository->authUser(
                $user_email,
                $user_password,
            );

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['user_id'] ?? null,
                    'email' => $user['user_email'] ?? '',
                    'role' => $user['user_role'] ?? 'user'
                ];
                // var_dump($_SESSION);
                $_SESSION['message'] = "Авторизация успешна";
            } else {
                $_SESSION['message'] = "Неверный email или пароль";
                header('Location: /users/auth');
                exit;
            }
            header('Location: /tickets');
            exit;
        }
        public function logout() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_unset();
            session_destroy();
            header('Location: /users/auth');
            exit;
        }
        public function create(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
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