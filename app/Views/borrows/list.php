<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrows</title>
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
    <h1>Borrows</h1>

    <a href="/borrow/create" class="button">Borrow a Book</a>
    <a href="/book/index" class="button">Books</a>
    <a href="/user/index" class="button">Users</a>

    <table>
        <thead>
            <tr>
                <th>ID</th> 
                <th>User</th>
                <th>Book</th>
                <th>Borrowed At</th>
                <th>Due Date</th>
                <th>Returned At</th>
                <th>Late Fee</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($borrows)): ?>
                <?php $counter = 1; ?>
                <?php foreach ($borrows as $b): ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= htmlspecialchars($b['user_name'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($b['book_title'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars(date('Y-m-d', strtotime($b['borrowed_at'])), ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars(date('Y-m-d', strtotime($b['due_date'])), ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($b['returned_at'] ? date('Y-m-d', strtotime($b['returned_at'])) : '-', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars(number_format($b['late_fee'] ?? 0, 2), ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($b['status'], ENT_QUOTES) ?></td>
                    <td>
                        <?php if ($b['status'] === 'borrowed'): ?>
                            <a href="/borrow/returnBook/<?= htmlspecialchars($b['id'], ENT_QUOTES) ?>" class="button">Return</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $counter++; endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No borrows found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
