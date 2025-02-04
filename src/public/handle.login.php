<?php

$errors = [];

if (isset ($_POST['username'])) {
    $username = $_POST['username'];
}

if (isset ($_POST['password'])) {
    $password = $_POST['password'];
}


$pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute(['email' => $username]);

$user = $stmt->fetch();

if ($user === false) {
    $errors['username'] = 'username or password incorrect';
} else {
    $passwordDb = $user['password'];

    if (password_verify($password, $passwordDb)) {
        setcookie('user_id', $user['id']);
        header("Location: /catalog.php");
    } else {
        $errors['username'] = 'username or password incorrect';
    }
}

require_once './login_form.php';