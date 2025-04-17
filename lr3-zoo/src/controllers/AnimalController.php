<?php
    namespace src\controllers;
    
    use src\models\Animal;
    use src\models\Care;
    use src\services\validators\AnimalValidator;
    use src\lib\files\Files;

    use Twig\Environment;

    use Twig\Loader\FilesystemLoader;

    use Fawno\FPDF\FawnoFPDF;

    class AnimalController{
        private Animal $repository;
        private Care $care;

        private Environment $twig;
        public function __construct() {
            $this->repository = new Animal();
            $this->care = new Care();
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader);
        }
        public function index() {
            $filter_gender=trim($_GET["filter_gender"] ?? "");
            $filter_name=trim($_GET["filter_name"] ?? "");
            $animals = $this->repository->getFiltered($filter_gender,$filter_name);
            echo $this->twig->render('tables/table_animal.twig', 
            ['animals' => $animals,
            'selected_gender' => $filter_gender,
            'selected_name' => $filter_name,
            'user' => $_SESSION['user'] ?? null,
            ]);
        }

        public function generatePdf(): void {
        
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header("Location: /");
                exit;
            }

            function toWin1251($text): string {
                return iconv('UTF-8', 'windows-1251//IGNORE', $text);
            }
        
            $filter_name = trim($_GET["filter_name"] ?? "");
            $filter_gender = trim($_GET["filter_gender"] ?? "");
            $animals = $this->repository->getFiltered($filter_name, $filter_gender);
        
            $pdf = new FawnoFPDF();
            $pdf->AddPage();
            $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
            $pdf->SetFont('DejaVuSans', '', 14);
            $pdf->Cell(0, 10, toWin1251('Список животных'), 0, 1, 'C');
            $pdf->Ln(10);
        
            $pdf->SetFont('DejaVuSans', '', 12);
            $pdf->Cell(20, 10, toWin1251('ID'), 1);
            $pdf->Cell(40, 10, toWin1251('Имя'), 1);
            $pdf->Cell(30, 10, toWin1251('Пол'), 1);
            $pdf->Cell(30, 10, toWin1251('Возраст'), 1);
            $pdf->Cell(40, 10, toWin1251('Клетка'), 1);
            $pdf->Cell(40, 10, toWin1251('Уход'), 1);
            $pdf->Ln();
        
            foreach ($animals as $animal) {
                $pdf->Cell(20, 10, toWin1251($animal['animal_id']), 1);
                $pdf->Cell(40, 10, toWin1251($animal['animal_name']), 1);
                $pdf->Cell(30, 10, toWin1251($animal['animal_gender']), 1);
                $pdf->Cell(30, 10, toWin1251($animal['animal_age']), 1);
                $pdf->Cell(40, 10, toWin1251($animal['animal_cage']), 1);
                $pdf->Cell(40, 10, toWin1251($animal['care_type']), 1);
                $pdf->Ln();
            }
        
            $pdf->Output('I', 'animals.pdf');
        }

        public function form(){
            if (session_status() !== PHP_SESSION_NONE 
            && $_SESSION["user"]["role"] !== 'admin') {
                header("Location: /");
                exit;
            }
            $animals = $this->care->getAll();
            $message = $_SESSION["message"] ?? '';
            $_SESSION["message"] = '';
            echo $this->twig->render('forms/form_animal.twig', [
                'message' => $message,
                'user' => $_SESSION['user'] ?? null,
                'animals' => $animals,
            ]);
        }
        public function create() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /animals/create");
                exit;
            }
            if (isset($_FILES['csv-file']) && $_FILES['csv-file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['csv-file'];

                $message='';
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                finfo_close($finfo);

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                if (strtolower($extension) !== 'csv') {
                    $message .="Ошибка: файл должен иметь расширение .csv.\n";
                }

                if ($file['size'] > 2 * 1024 * 1024) {
                    $message .="Ошибка: файл слишком большой (макс. 2MB).\n";
                }

                if (($handle = fopen($file['tmp_name'], 'r')) === false) {
                    $message .="Ошибка: невозможно открыть файл.\n";
                }

                $rowCount = 0;
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $rowCount++;

                    if (count($row) !== 4) {
                        fclose($handle);
                        $message .= "Ошибка: в строке $rowCount должно быть 4 столбца (имя, пол, возраст, клетка).";
                    }

                    list($name, $gender, $age, $cage) = array_map('trim', $row);

                    $data = array(
                        "animal-name" => $name,
                        "animal-gender" => $gender,
                        "animal-age" => $age,
                        "animal-cage" => $cage,
                    );

                    $message .= AnimalValidator::validate($data);
                }
                if ($message===""){

                    Files::save($file);

                    $this->import(__DIR__ ."/../uploads/data.csv");

                }else{
                    $_SESSION["message"]=$message;
                }
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
            $animal_cage = trim($_POST['animal-cage']?? '');

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

        public function update() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /animals");
                exit;
            }
            
            $message = AnimalValidator::validate($_POST);
    
            if ($message!=='') {
                $_SESSION["message"] = $message;
                header("Location: /animals");
                exit;
            }
            $animal_id = trim($_POST['animal-id']?? '');
            $animal_name = trim($_POST['animal-name']?? '');
            $animal_gender = trim($_POST['animal-gender']?? '');
            $animal_age = trim($_POST['animal-age']?? '');
            $animal_cage = trim($_POST['animal-cage']?? '');

            $success = $this->repository->updateAnimal(
                $animal_id,
                $animal_name,
                $animal_gender,
                (int)$animal_age,
                (int)$animal_cage,
            );
    
            if ($success) {
                $_SESSION["message"] = "Животное успешно обновлено!";
            } else {
                $_SESSION["message"] = "Ошибка при обновлении в базе данных.";
            }
    
            header("Location: /animals");
            exit;
        }
        public function import($path){
            $success = $this->repository->import($path);
            if ($success){
                $_SESSION["message"] = "Данные считаны";
            } else {
                $_SESSION["message"] = "Ошибка при считывании данных";
            }
            header("Location: /animals/create");
            exit;
        }
    }
?>