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
    <script type="text/javascript"  src="script.js" defer></script>
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
    <form action="form.php" method="post" name="forms" id="forms">
        <h1>Главный зоопарк у дома</h1>
        <label for="animal-name">Название животного:</label>
        <input type="text" id="animal-name" name="animal-name" placeholder="Хомяк">
        <span id="animal-name-span"></span>
        <label for="animal-gender">Пол животного:</label>
        <select id="animal-gender" name="animal-gender">
            <option value="м">м</option>
            <option value="ж">ж</option>
        </select>
        <span id="animal-gender-span"></span>
        <label for="animal-age">Возвраст животного:</label>
        <input type="number" id="animal-age" name="animal-age" placeholder="10">
        <span id="animal-age-span"></span>
        <label for="cage">Клетка:</label>
        <input type="number" id="cage" name="cage" placeholder="10">
        <span id="cage-span"></span>
        <label for="care">Уход:</label>
        <select id="care" name="care">
            <option value="Давать орешки">Давать орешки</option>
            <option value="Кормить овощами">Кормить овощами</option>
            <option value="Чистить клетку">Чистить клетку</option>
            <option value="Играть с животным">Играть с животным</option>
        </select>
        <span id="care-span"></span>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>