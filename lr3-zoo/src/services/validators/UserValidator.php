<?php

    namespace src\services\validators;

    class UserValidator{
        public static function validate($data): string{
            
            $user_name= trim($data['user-name']?? '');
            $user_email = trim($data['user-email']?? '');
            $user_password = trim($data['user-password']?? '');
            $user_role = trim($data['user-role']?? '');
            
            $message="";
            
            if(empty($user_name)){
                $message = $message. "Имя пользователя не может быть пустым.\n";
            }
            elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $user_name)) {
                $message = $message. "Имя пользователя может содержать только буквы, пробелы и дефисы.\n";
            }
            if(empty($user_email)){
                $message = $message. "Email адрес не может быть пустым.\n";
            }
            elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $message = $message. "Некорректный email адрес.\n";
            }
            if(empty($user_password)){
                $message = $message. "Пароль не может быть пустым.\n";
            }
            elseif (strlen($user_password) < 8) {
                $message = $message. "Пароль должен быть не менее 8 символов.\n";
            }
            elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,])[A-Za-z\d@$!%*?&]{8,}$/', $user_password)) {
                $message = $message. "Пароль должен содержать как минимум одну заглавную букву, одну строчную букву, одну цифру и один специальный символ.\n";
            }
            if(empty($user_role)){
                $message = $message. "Роль пользователя не может быть пустым.\n";
            }
            elseif (!in_array($user_role, ["admin", "user"])) {
                $message = $message. "Некорректная роль пользователя.\n";
            }
            return $message;
        }
    }

?>