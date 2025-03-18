<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user_name= trim($_POST['user-name']?? '');
        $user_email = trim($_POST['user-email']?? '');
        $user_password = trim($_POST['user-password']?? '');
        $user_role = trim($_POST['user-role']?? '');
    }
    $error=false;
    $message ="";
    if(empty($user_name)){
        $error = true;
        $message = $message. "Имя пользователя не может быть пустым.\n";
    }
    elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $user_name)) {
        $error = true;
        $message = $message. "Имя пользователя может содержать только буквы, пробелы и дефисы.\n";
    }
    if(empty($user_email)){
        $error = true;
        $message = $message. "Email адрес не может быть пустым.\n";
    }
    elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $message = $message. "Некорректный email адрес.\n";
    }
    if(empty($user_password)){
        $error = true;
        $message = $message. "Пароль не может быть пустым.\n";
    }
    elseif (strlen($user_password) < 8) {
        $error = true;
        $message = $message. "Пароль должен быть не менее 8 символов.\n";
    }
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $user_password)) {
        $error = true;
        $message = $message. "Пароль должен содержать как минимум одну заглавную букву, одну строчную букву, одну цифру и один специальный символ.\n";
    }
    if(empty($user_role)){
        $error = true;
        $message = $message. "Роль пользователя не может быть пустым.\n";
    }
    elseif (!in_array($user_role, ["admin", "user"])) {
        $error = true;
        $message = $message. "Некорректная роль пользователя.\n";
    }
    if (!$error){
        //TODO add to DB
    }
    $_SESSION['message'] = $message;
    header('Location: /index.php');
    exit;
?>