<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Animals</title>
</head>
<body>
    <h1>Animals</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Cage</th>
            <th>Care</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($animals as $animal): ?>
        <tr>
            <td><?php echo $animal['animal_id']; ?></td>
            <td><?php echo $animal['animal_name']; ?></td>
            <td><?php echo $animal['animal_gender']; ?></td>
            <td><?php echo $animal['animal_age']; ?></td>
            <td><?php echo $animal['animal_cage']; ?></td>
            <td><?php echo $animal['animal_care']; ?></td>
            <td>
                <a href="/show/<?php echo $animal['animal_id']; ?>">View</a>
                <a href="/edit/<?php echo $animal['animal_id']; ?>">Edit</a>
                <a href="/delete/<?php echo $animal['animal_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="/create">Add New Animal</a>
</body>
</html>