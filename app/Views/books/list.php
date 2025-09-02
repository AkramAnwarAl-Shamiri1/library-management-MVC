<?php

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Books</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
h1 { color: #333; }
table { border-collapse: collapse; width: 100%; margin-top: 15px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
th { background-color: #007BFF; color: #fff; }
tr:nth-child(even) { background-color: #f7f7f7; }
a.button { padding: 6px 12px; text-decoration: none; border-radius: 4px; border: 1px solid #007BFF; background-color: #007BFF; color: #fff; cursor: pointer; }
a.button:hover { background-color: #0056b3; border-color: #0056b3; }
nav a { margin-right: 12px; font-weight: bold; }
</style>
</head>
<body>
<h1>Books</h1>

<nav>
    <a href="/library-mvc/public/book/create" class="button">Add New Book</a>
    <a href="/library-mvc/public/user/index" class="button">Users</a>
    <a href="/library-mvc/public/borrow/index" class="button">Borrows</a>
</nav>

<table>
<thead>
<tr>
<th>ID</th> 
<th>Title</th>
<th>Author</th>
<th>Available / Total</th>
<th>Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($books)): ?>
    <?php $counter = 1; ?>
    <?php foreach ($books as $b): ?>
    <tr>
        <td><?= $counter ?></td> 
        <td><?= htmlspecialchars($b['title'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($b['author'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($b['available_copies'], ENT_QUOTES) ?> / <?= htmlspecialchars($b['total_copies'], ENT_QUOTES) ?></td>
        <td>
            <a href="/library-mvc/public/book/edit/<?= $b['id'] ?>" class="button">Edit</a>
            <a href="/library-mvc/public/book/delete/<?= $b['id'] ?>" class="button" onclick="return confirm('Delete this book?')">Delete</a>
        </td>
    </tr>
    <?php $counter++; ?>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="5" style="text-align:center;">No books found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</body>
</html>
