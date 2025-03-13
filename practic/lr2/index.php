<?php
    require "db.php";

    $stmt = $pdo->query("SELECT * FROM users");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump($users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            width: 50%;
            border-collapse: 20px;
        }
        th{
            background-color: aqua;
        }
    </style>
</head>
<body>
    <h2>Список пользователей</h2>
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>age</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id']?></td>
                <td><?= $user['name']?></td>
                <td><?= $user['email']?></td>
                <td><?= $user['age']?></td>
            </tr>
        <?php endforeach;?>
    </table>
</body>
</html>