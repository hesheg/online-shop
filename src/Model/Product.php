<?php

require_once '../Model/Model.php';
class Product extends Model
{
    public function getProducts(): array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll();

        return $products;
    }

    public function getProdByProdIdAndUserId(int $productId, int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId and user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $result = $stmt->fetch();

        return $result;
    }

    public function insertProducts(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateProducts(int $amount, int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId and product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function getById(int $productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $result = $stmt->fetch();

        return $result;
    }
}