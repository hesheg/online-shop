<?php

echo "<pre>";
//print_r($_GET);

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];


if (ctype_alpha($name)) {
    echo '';
} else {
    exit('В имени не должны быть цифры и другие знаки. Только латинские буквы');
}

$nameValid = '';
if (strlen($name) >= 2 && strlen($name) <= 50) {
    $nameValid .= $name;
} else {
    exit('Имя не должно иметь меньше 2 или больше 50 символов');
}

$emailToLower = strtolower($email);
$emailValid = trim($emailToLower);


if ($password === $passwordRep) {
    echo '';
} else {
    exit('Неправильно введен повторный пароль');
}


$passwordValid = '';

if (strlen($password) >= 8 && strlen($password) <= 20) {
    $passwordValid .= $password;
} else {
    exit('Длина пароля должна быть больше или равно 8 символам и меньше или равно 20 символам');
}


$pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$nameValid', '$emailValid', '$passwordValid')");
echo "\n";


$statement = $pdo->query("SELECT max(id) FROM users");
$data = $statement->fetch();
echo "<pre>";


$statement = $pdo->query("SELECT * FROM users WHERE id = $data[0] - 1");
$res = $statement->fetch();
print_r($res);