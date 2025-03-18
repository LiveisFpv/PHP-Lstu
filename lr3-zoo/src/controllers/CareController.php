<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $care_type = trim($_POST['care-type']?? '');
        $animal_name = trim($_POST['animal-name'] ?? '');
    }
    $error=false;
    $message ="";
    if(empty($care_type)){
        $error = true;
        $message = $message . "Тип ухода не может быть пустым.\n";
    }
    elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $care_type)) {
        $error = true;
        $message = $message . "Тип ухода может содержать только буквы, пробелы и дефисы.\n";
    }
    if(empty($animal_name)){
        $error = true;
        $message = $message . "Название животного не может быть пустым.\n";
    }
    elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $animal_name)) {
        $error = true;
        $message = $message . "Название животного может содержать только буквы, пробелы и дефисы.\n";
    }
    if (!$error) {
        //TODO add to db
    }
    $_SESSION['message'] = $message;
    header('Location: /index.php');
    exit;
?>