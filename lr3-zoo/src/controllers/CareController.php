<?php
    namespace src\controllers;

    use src\models\Care;
    use src\services\validators\CareValidator;

    use Twig\Environment;

    use Twig\Loader\FilesystemLoader;

    class CareController{
        private Care $repository;
        private Environment $twig;
        public function __construct() {
            $this->repository = new Care();
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader);
        }
        public function index(){
            if (session_status() !== PHP_SESSION_NONE 
            && $_SESSION["user"]["role"] !== 'admin') {
                header("Location: /");
                exit;
            }
            $cares = $this->repository->getAll();
            $filter_name=trim($_GET["filter_name"] ?? "");
            $cares = $this->repository->getFiltered($filter_name);
            echo $this->twig->render('tables/table_care.twig', 
            ['cares' => $cares,
            'selected_name' => $filter_name,
            'user' => $_SESSION['user'] ?? null,
            ]);
        }
        public function form(){
            if (session_status() !== PHP_SESSION_NONE 
            && $_SESSION["user"]["role"] !== 'admin') {
                header("Location: /");
                exit;
            }
            $message = $_SESSION["message"] ?? '';
            $_SESSION["message"] = '';
            echo $this->twig->render('forms/form_care.twig', [
                'message' => $message,
                'user' => $_SESSION['user'] ?? null,
            ]);
        }
        public function create(){
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