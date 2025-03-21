<?php
    namespace src\controllers;
    
    use src\models\Animal;
    use src\services\validators\AnimalValidator;
    use src\lib\files\Files;

    use Twig\Environment;

    use Twig\Loader\FilesystemLoader;

    class AnimalController{
        private Animal $repository;

        private Environment $twig;
        public function __construct() {
            $this->repository = new Animal();
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
            ]);
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
                        "cage" => $cage,
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