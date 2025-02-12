<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $name = trim($_POST['name']?? '');
        $email = trim($_POST['email']?? '');
        $name = trim($_POST['name']?? '');
        $name = trim($_POST['name']?? '');

        $csvFile = 'data.csv';

        $dataRow = [$name, $email];
        if (($file=fopen($csvFile, 'a'))!==false){
            fputcsv($file,$dataRow);
            fclose($file);
            $message = 'Данные успешно сохранены';
        } else {
            $message = 'Ошибка при сохранении';
        }
    }
?>