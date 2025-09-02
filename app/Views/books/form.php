<?php

$id = $book['id'] ?? null;
$title = $book['title'] ?? '';
$author = $book['author'] ?? '';
$totalCopies = $book['total_copies'] ?? 1;
$availableCopies = $book['available_copies'] ?? 1;
$dailyLateFee = $book['daily_late_fee'] ?? 0.5;

$isEdit = isset($book);
$formAction = $isEdit 
    ? "/library-mvc/public/book/edit/{$id}" 
    : "/library-mvc/public/book/create";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Edit Book' : 'Add Book' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
        h1 { color: #333; }
        label { display: block; margin-bottom: 10px; font-weight: bold; }
        input { padding: 6px; width: 250px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 8px 16px; margin-top: 10px; cursor: pointer; background-color: #007BFF; color: #fff; border: none; border-radius: 4px; }
        button:hover { background-color: #0056b3; }
        a { display: inline-block; margin-top: 10px; text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        nav a { margin-right: 15px; font-weight: bold; }
        form { background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 300px; }
    </style>
</head>
<body>
    <h1><?= $isEdit ? 'Edit' : 'Add' ?> Book</h1>

   
    <nav>
        <a href="/library-mvc/public/user/index">Users</a>
        <a href="/library-mvc/public/book/index">Books</a>
        <a href="/library-mvc/public/borrow/index">Borrows</a>
    </nav>

    <form method="post" action="<?= htmlspecialchars($formAction, ENT_QUOTES) ?>">
        <label for="title">Title:
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
        </label>
        <label for="author">Author:
            <input type="text" id="author" name="author" required value="<?= htmlspecialchars($author, ENT_QUOTES) ?>">
        </label>
        <label for="total_copies">Total Copies:
            <input type="number" id="total_copies" name="total_copies" min="1" required value="<?= htmlspecialchars($totalCopies, ENT_QUOTES) ?>">
        </label>
        <label for="available_copies">Available Copies:
            <input type="number" id="available_copies" name="available_copies" min="0" required value="<?= htmlspecialchars($availableCopies, ENT_QUOTES) ?>">
        </label>
        <label for="daily_late_fee">Daily Late Fee:
            <input type="number" id="daily_late_fee" name="daily_late_fee" step="0.01" min="0" value="<?= htmlspecialchars($dailyLateFee, ENT_QUOTES) ?>">
        </label>
        <button type="submit"><?= $isEdit ? 'Update' : 'Save' ?></button>
    </form>

    <a href="/library-mvc/public/book/index">Back to Books List</a>
</body>
</html>
