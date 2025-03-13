<?php
    require 'db.php';

    $file = fopen("data.csv","r");

    fgetcsv($file);

    while (($row = fgetcsv($file,1000,","))!=false) {
        $stmt = $pdo->prepare("INSERT INTO users(name,email,age) VALUES(?, ?, ?)");
        $stmt->execute([$row[0],$row[1],$row[2]]);
    }
    fclose($file);
    echo "Данные добавлены";
?>