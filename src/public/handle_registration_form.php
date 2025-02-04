<?php

$errors = [];

function validateName ($name)
{
    if (strlen($name) < 2 || strlen($name) > 40) {
        return 'В имени должно быть больше 2 и меньше 40 символов';
    } elseif (!ctype_alpha($name)) {
        return 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
    }
}


if (isset ($_POST['name'])) {
    $name = $_POST['name'];

      if (validateName($name) !== null) {
        $errors['name'] = validateName($name);
    }
}


function validateEmail ($email)
{
    $emailToLower = strtolower($email);
    $email = trim($emailToLower);

    if (strlen($email) < 5) {
        return 'Количество символов в email должно быть больше 5';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return 'В email обязательно должны быть символы "@" и "."';
    }

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetch();

    if ($count > 0) {
        return 'Пользователь с таким email уже существует';
    }
}

if (isset ($_POST['email'])) {
    $email = $_POST['email'];

    if (validateEmail($email) !== null) {
        $errors ['email'] = validateEmail($email);
    }
}


function validatePassword ($password)
{
    if (strlen($password) < 8 || strlen($password) > 20) {
        return 'Длина пароля должна быть больше 8 и меньше 20 символов';
    }
}


if (isset ($_POST['psw']) && isset ($_POST['psw-repeat'])) {
    $password = $_POST['psw'];
    $passwordRep = $_POST['psw-repeat'];

    if (validatePassword($password) !== null) {
        $errors['psw'] = validatePassword($password);
    } elseif ($password !== $passwordRep) {
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
//    print_r($data);

    header("Location: /login_form.php");
}

require_once './registration_form.php';
