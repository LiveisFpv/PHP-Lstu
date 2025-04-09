<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Зоо</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/lib/BasicValid.js" defer></script>
    <script src="/js/hamburger.js" defer></script>
</head>
<body>
<?php include __DIR__.'./../links.php'; ?>
    <script>
        window.onload = function() {
            let message = <?php echo json_encode($_SESSION["message"] ?? ""); ?>;
            if (message) {
                alert(message);
            }
            <?php $_SESSION["message"] = ""; ?>
        };
    </script>
    <div class="form-container">
        <h2>Авторизация</h2>
        <form action="auth" method="post" name="forms" id="forms">
            
            <div class="form-group">
            <label for="user-email">Email:</label>
            <input type="text" id="user-email" name="user-email" placeholder="test@mail.ru">
            <span id="user-email-span"></span>
            </div>
            
            <div class="form-group">
            <label for="user-password">Пароль:</label>
            <input type="text" id="user-password" name="user-password" placeholder="password">
            <span id="user-password-span"></span>
            </div>
            
            <button type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>