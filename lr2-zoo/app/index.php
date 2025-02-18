<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lr2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="form.php" method="post">
        <h1>Главный зоопарк у дома</h1>
        <label for="animal-name">Название животного:</label>
        <input type="text" id="animal-name" name="animal-name" required>
        <label for="animal-gender">Пол животного:</label>
        <input type="text" id="animal-gender" name="animal-gender" required>
        <label for="animal-age">Возвраст животного:</label>
        <input type="number" id="animal-age" name="animal-age" required>
        <label for="cage">Клетка:</label>
        <input type="text" id="cage" name="cage" required>
        <label for="care">Уход:</label>
        <input type="text" id="care" name="care" required>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>