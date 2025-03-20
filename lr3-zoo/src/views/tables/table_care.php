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
        <h2>Уход за животными</h2>
        <table>
            <tr>
                <th>care_id</th>
                <th>animal_name</th>
                <th>care_type</th>
            </tr>
            <?php foreach ($cares as $care): ?>
                <tr>
                    <td><?= $care['care_id']?></td>
                    <td><?= $care['animal_name']?></td>
                    <td><?= $care['care_type']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</body>
</html>