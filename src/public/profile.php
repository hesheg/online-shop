<?php

session_start();

    $errors = [];

    if (!isset($_SESSION['user_id'])) {
        header("Location: /login_form.php");
    } else {
        $data = $_SESSION['user_id'];

        $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $data]);
        $user = $stmt->fetch();

        require_once './profile_page.php';
    }


