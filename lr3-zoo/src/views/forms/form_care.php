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
    <script src="/js/script.js" defer></script>
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
    <form action="create" method="post" name="forms" id="forms">
        <h1>Уход за животным</h1>
        <label for="animal-name">Название животного:</label>
        <input type="text" id="animal-name" name="animal-name" placeholder="Хомяк">
        <span id="animal-name-span"></span>
        <label for="care-type">Уход за животным:</label>
        <input type="number" id="care-type" name="care-type" placeholder="10">
        <span id="care-type-span"></span>
    </form>
</body>
</html>