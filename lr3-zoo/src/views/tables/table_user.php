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
        <h2>Пользователи</h2>
        <table>
            <tr>
                <th>user_id</th>
                <th>user_name</th>
                <th>user_email</th>
                <th>user_password</th>
                <th>user_role</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id']?></td>
                    <td><?= $user['user_name']?></td>
                    <td><?= $user['user_email']?></td>
                    <td><?= $user['user_password']?></td>
                    <td><?= $user['user_role']?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</body>
</html>