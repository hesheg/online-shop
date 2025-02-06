<?php

function validate(array $data): array
{
    $errors = [];

    if (!isset ($data['username'])) {
        $errors['username'] = 'Поле username обязательно для заполнения';
    }

    if (!isset ($data['password'])) {
        $errors['password'] = 'Поле password обязательно для заполнения';
    }

    return $errors;
}

$errors = validate($_POST);

if (empty($errors)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $username]);
    $user = $stmt->fetch();

    if ($user === false) {
        $errors['username'] = 'username or password incorrect';
    } else {
        $passwordDb = $user['password'];

        if (password_verify($password, $passwordDb)) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
//        setcookie('user_id', $user['id']);
            header("Location: /profile.php");
        } else {
            $errors['username'] = 'username or password incorrect';
        }
    }
}

require_once './login_form.php';