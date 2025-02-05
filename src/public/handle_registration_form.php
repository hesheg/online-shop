<?php
function validate (array $data): array
{
    $errors = [];

    if (isset($data['name'])) {
        $name = $data['name'];

        if (strlen($name) < 2 || strlen($name) > 40) {
            $errors['name'] = 'В имени должно быть от 2 до 40 символов';
        } elseif (!ctype_alpha($name)) {
            $errors['name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
        }
    } else {
        $errors['name'] = 'Имя должно быть заполнено';
    }

    if (isset($data['email'])) {
        $email = $data['email'];

        $emailToLower = strtolower($email);
        $email = trim($emailToLower);

        if (strlen($email) < 5) {
            $errors['email'] = 'Количество символов в email должно быть больше 5';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'В email обязательно должны быть символы "@" и "."';
        } else {
            $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $count = $stmt->fetch();

            if ($count > 0) {
                $errors['email'] = 'Пользователь с таким email уже существует';
            }
        }
    } else {
        $errors['email'] = 'Поле email должно быть заполнено';
    }


    if (isset($data['psw'])) {
        $password = $_POST['psw'];

        if (strlen($password) < 8 || strlen($password) > 20) {
            $errors['psw'] = 'Длина пароля должна быть от 8 до 20 символов';
        }
        $passwordRep = $_POST['psw-repeat'];
        if ($password !== $passwordRep) {
            $errors['psw-repeat'] = 'Пароли не совпадают';
        }
    } else {
        $errors['psw'] = 'Введите пароль';
    }

    return $errors;
}

$errors = validate($_POST);

if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRep = $_POST['psw-repeat'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

//    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//    $stmt->execute(['email' => $email]);
//    $data = $stmt->fetch();
//    print_r($data);

    header("Location: /login_form.php");
}

require_once './registration_form.php';


