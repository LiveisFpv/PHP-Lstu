<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lr2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script>
        window.onload = function() {
            let message = <?php echo json_encode($_SESSION["message"] ?? ""); ?>;
            if (message != ""){
                alert(message);
            }
            <?php $_SESSION["message"]="";?>
        };
    </script>
    <form action="form.php" method="post">
        <h1>Главный зоопарк у дома</h1>
        <label for="animal-name">Название животного:</label>
        <input type="text" id="animal-name" name="animal-name" required>
        <label for="animal-gender">Пол животного:</label>
        <input type="text" id="animal-gender" name="animal-gender" required>
        <label for="animal-age">Возвраст животного:</label>
        <input type="number" id="animal-age" name="animal-age" required min="1">
        <label for="cage">Клетка:</label>
        <input type="number" id="cage" name="cage" required min="1">
        <label for="care">Уход:</label>
        <input type="text" id="care" name="care" required>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>