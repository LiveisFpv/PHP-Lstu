<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $animal_name = trim($_POST['animal-name']?? '');
        $animal_gender = trim($_POST['animal-gender']?? '');
        $animal_age = trim($_POST['animal-age']?? '');
        $cage = trim($_POST['cage']?? '');
        $care = trim($_POST['care']?? '');

        $csvFile = 'data.csv';

        $dataRow = [$animal_name,$animal_gender ,$animal_age,$cage,$care];
        if (($file=fopen($csvFile, 'a'))!==false){
            fputcsv($file,$dataRow);
            fclose($file);
            $message = 'Данные успешно сохранены';
        } else {
            $message = 'Ошибка при сохранении';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Данные приняты
</body>
</html>