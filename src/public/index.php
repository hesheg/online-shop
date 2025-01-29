<?php

$pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('Dasha', 'dasha@mail.ru', '4321')");

$statement = $pdo->query("SELECT * FROM users");
$data = $statement->fetch();
echo "<pre>";
print_r($data);

