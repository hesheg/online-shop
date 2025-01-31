<?php

$errors = [];

if (isset ($_POST['name'])) {
    $name = $_POST['name'];

    if (strlen($name) < 2 || strlen($name) > 40) {
        $errors['name'] = 'В имени должно быть больше 2 и меньше 40 символов';
    } elseif (!ctype_alpha($name)) {
        $errors['name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
    }
}

if (isset ($_POST['email'])) {
    $email = $_POST['email'];

    $emailToLower = strtolower($email);
    $email = trim($emailToLower);

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

    $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetch();

     if (strlen($email) < 5) {
        $errors['email'] = 'Количество символов в email должно быть больше 5';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'В email обязательно должны быть символы "@" и "."';
    } elseif ($count[0] > 0) {
        $errors['email'] = 'Пользователь с таким email уже существует';
    }
}

if (isset ($_POST['psw'])) {
    $password = $_POST['psw'];
    if (strlen($password) < 8 || strlen($password) > 20) {
        $errors['psw'] = 'Длина пароля должна быть больше 8 и меньше 20 символов';
    }
}

if (isset ($_POST['psw-repeat'])) {
    $passwordRep = $_POST['psw-repeat'];

    if ($password !== $passwordRep) {
    $errors['psw-repeat'] = 'Пароли не совпадают';
    }
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();
    print_r($data);
}

require_once './registration_form.php';