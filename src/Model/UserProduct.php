<?php

namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $totalSum;


    protected function getTableName(): string
    {
        return 'user_products';
    }

    private function createObj(array|false $user): self|null
    {
        if (!$user) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->userId = $user['user_id'];
        $obj->productId = $user['product_id'];
        $obj->amount = $user['amount'];

        return $obj;
    }


    public function getAllByUserId(int $userId): array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();

        $result = [];
        foreach ($userProducts as $userProduct) {
            $obj = $this->createObj($userProduct);
            $result[] = $obj;
        }

        return $result;
    }

    public function deleteByUserId(int $userId)
    {
       $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId");
       $stmt->execute(['userId' => $userId]);
    }

    public function deleteByUserIdAndProdId(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId and product_id = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function getByProdIdAndUserId(int $productId, int $userId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :productId and user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $user = $stmt->fetch();

        return $this->createObj($user);
    }

    public function insertProducts(int $userId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateProducts(int $amount, int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id = :userId and product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }

    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }
}