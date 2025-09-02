<?php

$formAction = "/library-mvc/public/borrow/create";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow a Book</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        h1 { color: #333; }
        form { background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 350px; }
        label { display: block; margin-bottom: 12px; font-weight: bold; }
        select, input { width: 100%; padding: 6px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 16px; margin-top: 12px; cursor: pointer; background-color: #007BFF; color: #fff; border: none; border-radius: 4px; }
        button:hover { background-color: #0056b3; }
        a { display: inline-block; margin-top: 10px; text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        nav a { margin-right: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Borrow a Book</h1>

   
    <nav>
        <a href="/library-mvc/public/borrow/index" class="button">Borrows</a>
        <a href="/library-mvc/public/book/index" class="button">Books</a>
        <a href="/library-mvc/public/user/index" class="button">Users</a>
    </nav>

    <form method="post" action="<?= htmlspecialchars($formAction, ENT_QUOTES) ?>">
        <label for="user_id">User:
            <select id="user_id" name="user_id" required>
                <?php foreach ($users as $u): ?>
                    <option value="<?= htmlspecialchars($u['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($u['name'], ENT_QUOTES) ?> (<?= htmlspecialchars($u['email'], ENT_QUOTES) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label for="book_id">Book:
            <select id="book_id" name="book_id" required>
                <?php foreach ($books as $bk): ?>
                    <option value="<?= htmlspecialchars($bk['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($bk['title'], ENT_QUOTES) ?> by <?= htmlspecialchars($bk['author'], ENT_QUOTES) ?> - Avail: <?= htmlspecialchars($bk['available_copies'], ENT_QUOTES) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label for="due_date">Due date:
            <input type="date" id="due_date" name="due_date" required>
        </label>

        <button type="submit">Borrow</button>
    </form>

    <a href="/library-mvc/public/borrow/index">Back to Borrows List</a>
</body>
</html>
