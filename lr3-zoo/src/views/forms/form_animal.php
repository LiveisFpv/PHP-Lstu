<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Зоо</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/lib/BasicValid.js" defer></script>
    <script src="/js/validators/AnimalValid.js" defer></script>
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
    <div class="form-container">
        <h2>Главный зоопарк у дома</h2>
        <form action="create" method="post" name="forms" id="forms">
            <div class="form-group">
            <label for="animal-name">Название животного:</label>
            <input type="text" id="animal-name" name="animal-name" placeholder="Хомяк">
            <span id="animal-name-span"></span>
            </div>
            <div class="form-group">
            <label for="animal-gender">Пол животного:</label>
            <select id="animal-gender" name="animal-gender">
                <option value="м">м</option>
                <option value="ж">ж</option>
            </select>
            <span id="animal-gender-span"></span>
            </div>
            <div class="form-group">
            <label for="animal-age">Возвраст животного:</label>
            <input type="number" id="animal-age" name="animal-age" placeholder="10">
            <span id="animal-age-span"></span>
            </div>
            <div class="form-group">
            <label for="cage">Клетка:</label>
            <input type="number" id="cage" name="cage" placeholder="10">
            <span id="cage-span"></span>
            </div>
            <button type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>