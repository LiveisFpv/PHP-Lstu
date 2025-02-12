<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lr2</title>
</head>
<body>
    <h1>ДАННЫЕ ДАВАЙ</h1>

    <?php if (!empty($message)):?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="form.php" method="post">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>