<?php

$id    = $user['id'] ?? null;
$name  = $user['name'] ?? '';
$email = $user['email'] ?? '';
$formAction = isset($user) 
    ? "/library-mvc/public/user/edit/{$id}" 
    : "/library-mvc/public/user/create";
?>
<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?= isset($user) ? 'Edit' : 'Add' ?> User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9;  }
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
    <h1><?= isset($user) ? 'Edit' : 'Add' ?> User</h1>

   
    <nav>
        <a href="/library-mvc/public/user/index">Users</a>
        <a href="/library-mvc/public/book/index">Books</a>
        <a href="/library-mvc/public/borrow/index">Borrows</a>
    </nav>

    <form method="post" action="<?= htmlspecialchars($formAction, ENT_QUOTES) ?>">
        <label for="name">Name:
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name, ENT_QUOTES) ?>">
        </label>
        <label for="email">Email:
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email, ENT_QUOTES) ?>">
        </label>
        
        <button type="submit"><?= isset($user) ? 'Update' : 'Save' ?></button>
    </form>

    <a href="/library-mvc/public/user/index">Back to Users List</a>
</body>
</html>
