<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007BFF; color: #fff; }
        tr:nth-child(even) { background-color: #f7f7f7; }
        a.button, button { padding: 6px 12px; text-decoration: none; border-radius: 4px; border: 1px solid #007BFF; background-color: #007BFF; color: #fff; cursor: pointer; }
        a.button:hover, button:hover { background-color: #0056b3; border-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Users</h1>
    <nav>
        <a href="/library-mvc/public/user/create" class="button">Add New User</a>
        <a href="/library-mvc/public/book/index" class="button">Books</a>
        <a href="/library-mvc/public/borrow/index" class="button">Borrows</a>
    </nav>
    <table>
        <thead>
            <tr>
                <th>ID</th> 
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php $counter = 1; ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= htmlspecialchars($u['name'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($u['email'], ENT_QUOTES) ?></td>
                    <td>
                        <a href="/user/edit/<?= $u['id'] ?>" class="button">Edit</a>
                        <a href="/user/delete/<?= $u['id'] ?>" class="button">Delete</a>
                    </td>
                </tr>
                <?php $counter++; endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
