<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="table-container">
        <h2>Зоопарк у дома</h2>
        <table>
            <tr>
                <th>animal_id</th>
                <th>animal_name</th>
                <th>animal_gender</th>
                <th>animal_age</th>
                <th>animal_cage</th>
            </tr>
            <?php foreach ($animals as $animal): ?>
                <tr>
                    <td><?= $animal['animal_id']?></td>
                    <td><?= $animal['animal_name']?></td>
                    <td><?= $animal['animal_gender']?></td>
                    <td><?= $animal['animal_age']?></td>
                    <td><?= $animal['animal_cage']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</body>
</html>