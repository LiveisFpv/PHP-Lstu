<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $animal_name = trim($_POST['animal-name']?? '');
        $animal_gender = trim($_POST['animal-gender']?? '');
        $animal_age = trim($_POST['animal-age']?? '');
        $cage = trim($_POST['cage']?? '');
        $care = trim($_POST['care']?? '');

        $error=false;
        $message ="";
        if(empty($animal_name)){
            $error = true;
            $message = $message . "Название животного не может быть пустым.\n";
        }
        elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $animal_name)) {
            $error = true;
            $message = $message . "Название животного может содержать только буквы, пробелы и дефисы.\n";
        }
        
        if (empty($animal_gender)) {
            $error = true;
            $message = $message . "Пол животного не может быть пустым.\n";
        } elseif ($animal_gender != "м" && $animal_gender != "ж") {
            $error = true;
            $message = $message . "Пол животного должен быть 'м' (мужской) или 'ж' (женский).\n";
        }

        if (!filter_var($cage, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 1000]])) {
            $error = true;
            $message = $message . "Номер клетки должен быть целым числом от 1 до 1000.\n";
        }

        if (empty($care)) {
            $error = true;
            $message = $message . "Поле ухода не может быть пустым.\n";
        } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $care)) {
            $error = true;
            $message = $message . "Поле ухода может содержать только буквы, пробелы и дефисы.\n";
        }
        

        

        if ($error===false){
            $csvFile = 'data.csv';

            $dataRow = [$animal_name,$animal_gender ,$animal_age,$cage,$care];
            if (($file=fopen($csvFile, 'a'))!==false){
                fputcsv($file,$dataRow);
                fclose($file);
                $message = 'Данные успешно сохранены';
            } else {
                $message = 'Ошибка при сохранении';
            }
        }
    }
    $_SESSION["message"]= $message;
    //Redirect
    header("Location: /index.php");
    exit;
?>