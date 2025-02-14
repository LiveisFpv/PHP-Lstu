<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lr2</title>
</head>
<body>
    <h1>Хакеры хотят данные</h1>

    <form action="form.php" method="post">
        <label for="animal-name">Название животного:</label>
        <input type="text" id="animal-name" name="animal-name" required><br><br>
        <label for="animal-gender">Пол животного:</label>
        <input type="text" id="animal-gender" name="animal-gender" required><br><br>
        <label for="animal-age">Возвраст животного:</label>
        <input type="number" id="animal-age" name="animal-age" required><br><br>
        <label for="cage">Клетка:</label>
        <input type="text" id="cage" name="cage" required><br><br>
        <label for="care">Уход:</label>
        <input type="text" id="care" name="care" required><br><br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>