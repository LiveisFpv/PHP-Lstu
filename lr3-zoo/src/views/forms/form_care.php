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
    <script src="/js/validators/CareValid.js" defer></script>
    <script src="/js/hamburger.js" defer></script>
</head>
<body>
    <script>
        window.onload = function() {
            let message = <?php echo json_encode($_SESSION["message"] ?? ""); ?>;
            if (message) {
                alert(message);
            }
            <?php $_SESSION["message"] = ""; ?>
        };
    </script>
    <?php include __DIR__.'./../links.php'; ?>
    <div class="form-container">
        <h2>Уход за животным</h2>
        <form action="create" method="post" name="forms" id="forms">
            <div class="form-group">
            <label for="animal-name">Название животного:</label>
            <input type="text" id="animal-name" name="animal-name" placeholder="Хомяк">
            <span id="animal-name-span"></span>
            </div>
            <div class="form-group">
            <label for="care-type">Уход за животным:</label>
            <input type="text" id="care-type" name="care-type" placeholder="Давать орешки каждый день">
            <span id="care-type-span"></span>
            </div>
            <button type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>