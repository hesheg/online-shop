<?php

require_once '../Model/Model.php';
class UserProducts extends Model
{
    public function getUserProducts(): array|false
    {
        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();

        $products = [];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $stmt = $this->pdo->query("SELECT * FROM products WHERE id = $productId");
            $product = $stmt->fetch();
            $product['amount'] = $userProduct['amount'];

            $products[] = $product;
        }

        return $userProducts;
    }
}