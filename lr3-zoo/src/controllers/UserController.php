<?php
    namespace src\controllers;

    use src\models\User;
    use src\services\validators\UserValidator;
    
    use Twig\Environment;

    use Twig\Loader\FilesystemLoader;

    use Fawno\FPDF\FawnoFPDF;

    class UserController{
        private User $repository;

        private Environment $twig;
        public function __construct(){
            $this->repository = new User();
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader);
        }
        public function profile(){
            if (session_status() === PHP_SESSION_NONE){
                header("Location: /");
                exit;
            }
            echo $this->twig->render('profile.twig',
            ['user' => $_SESSION['user'] ?? null,
            ]);
        }
        public function index(){
            if (session_status() !== PHP_SESSION_NONE 
            && $_SESSION["user"]["role"] !== 'admin') {
                header("Location: /");
                exit;
            }
            $filter_name=trim($_GET["filter_name"] ?? "");
            $filter_role=trim($_GET["filter_role"] ?? "");
            $users = $this->repository->getFiltered($filter_name,$filter_role);
            echo $this->twig->render('tables/table_user.twig',
            ['users' => $users,
            'selected_name' => $filter_name,
            'selected_role' => $filter_role,
            'user' => $_SESSION['user'] ?? null,
            ]);
        }

        public function generatePdf(): void {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header("Location: /");
                exit;
            }
        
            $filter_name = trim($_GET["filter_name"] ?? "");
            $filter_role = trim($_GET["filter_role"] ?? "");
            $users = $this->repository->getFiltered($filter_name, $filter_role);
            function toWin1251($text): string {
                return iconv('UTF-8', 'windows-1251//IGNORE', $text);
            }

            $pdf = new FawnoFPDF();
            $pdf->AddPage();
            $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
            $pdf->SetFont('DejaVuSans', '', 14);
            $pdf->Cell(0, 10, toWin1251('Список пользователей'), 0, 1, 'C');
            $pdf->Ln(10);
        
            $pdf->SetFont('DejaVuSans', '', 12);
            $pdf->Cell(20, 10, toWin1251('ID'), 1);
            $pdf->Cell(50, 10, toWin1251('Имя'), 1);
            $pdf->Cell(60, 10, toWin1251('Email'), 1);
            $pdf->Cell(30, 10, toWin1251('Роль'), 1);
            $pdf->Ln();
        
            $pdf->SetFont('DejaVuSans', '', 12);
            foreach ($users as $user) {
                $pdf->Cell(20, 10, toWin1251($user['user_id']), 1);
                $pdf->Cell(50, 10, toWin1251($user['user_name']), 1);
                $pdf->Cell(60, 10, toWin1251($user['user_email']), 1);
                $pdf->Cell(30, 10, toWin1251($user['user_role']), 1);
                $pdf->Ln();
            }
        
            $pdf->Output('I', 'users.pdf');
        }

        public function form(){
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $message = $_SESSION["message"] ?? '';
            $_SESSION["message"] = '';
            echo $this->twig->render('forms/form_user.twig', [
                'message' => $message
            ]);
        }
        public function auth_index(){
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $message = $_SESSION["message"] ?? '';
            $_SESSION["message"] = '';
            echo $this->twig->render('forms/form_auth.twig', [
                'message' => $message
            ]);
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
                    'role' => $user['user_role'] ?? 'user',
                    'name' => $user['user_name'] ?? 'name'
                ];
                // var_dump($_SESSION);
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