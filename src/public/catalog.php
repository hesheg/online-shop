<?php

if (!isset($_COOKIE['user_id'])) {
    header("Location: /login_form.php");
}
$pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();

require_once './catalog_page.php';