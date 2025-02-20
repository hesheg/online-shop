<?php

class CartController
{
    public function cart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        require_once '../Model/UserProducts.php';
        $cart = new UserProducts();
        $userProducts = $cart->getUserProducts();
        $products = [];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];

            $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
            $stmt = $pdo->query("SELECT * FROM products WHERE id = $productId");
            $product = $stmt->fetch();
            $product['amount'] = $userProduct['amount'];

            $products[] = $product;
        }
        require_once '../Views/cart_page.php';
    }
}