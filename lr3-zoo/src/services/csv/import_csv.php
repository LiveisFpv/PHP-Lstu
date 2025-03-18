<?php
    require 'db.php';

    $file = fopen("data.csv","r");

    while (($row = fgetcsv($file,1000,","))!=false) {
        $stmt = $pdo->prepare("INSERT INTO animal(animal_name,animal_gender,animal_age,animal_cage,animal_care) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute([$row[0],$row[1],$row[2],$row[3],$row[4]]);
    }
    fclose($file);
    echo "Данные добавлены";
?>