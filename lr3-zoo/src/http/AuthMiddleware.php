<?php
    namespace src\http;
    class AuthMiddleware {
        public function handle() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            if (!isset($_SESSION['user'])) {
                $_SESSION['message'] = "Доступ запрещен";
                header('Location: /users/auth');
                exit;
            }
        }
    }
?>