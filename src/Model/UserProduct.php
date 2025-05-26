<?php

namespace Model;

use PDO;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $totalSum;


    public static function createObj(array|false $userProduct): self|null
    {
        if (!$userProduct) {
            return null;
        }

        $obj = new self();
        $obj->id = $userProduct['id'];
        $obj->userId = $userProduct['user_id'];
        $obj->productId = $userProduct['product_id'];
        $obj->amount = $userProduct['amount'];

        return $obj;
    }

    public static function createObjWithProducts(array|false $userProduct): self|null
    {
        $obj = static::createObj($userProduct);

        $dataProduct = [
            'id' => $userProduct['product_id'],
            'name' => $userProduct['name'],
            'description' => $userProduct['description'],
            'price' => $userProduct['price'],
            'image_url' => $userProduct['image_url']
        ];

        $product = Product::createObj($dataProduct);
        $obj->setProduct($product);

        return $obj;
    }


    public static function getAllByUserId(int $userId): array|null
    {
        $stmt = static::getPDO()->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();

        $result = [];
        foreach ($userProducts as $userProduct) {
            $obj = static::createObj($userProduct);
            $result[] = $obj;
        }

        return $result;
    }

    public static function getAllByUserIdWithProducts(int $userId): array|null
    {
        $stmt = static::getPDO()->query("SELECT 
        up.id,
        up.user_id,
        up.product_id AS product_id_from_up, 
        up.amount,
        p.id AS product_id,
        p.name,
        p.description,
        p.price,
        p.image_url
        FROM user_products up
        INNER JOIN products p ON up.product_id = p.id WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($userProducts as $userProduct) {
            $obj = static::createObjWithProducts($userProduct);
            $result[] = $obj;
        }

        return $result;
    }

    public static function deleteByUserId(int $userId)
    {
        $stmt = static::getPDO()->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);
    }

    public static function deleteByUserIdAndProdId(int $userId, int $productId)
    {
        $stmt = static::getPDO()->prepare("DELETE FROM user_products WHERE user_id = :userId and product_id = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public static function getByProdIdAndUserId(int $productId, int $userId): self|null
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM user_products WHERE product_id = :productId and user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $user = $stmt->fetch();

        return static::createObj($user);
    }

    public static function insertProducts(int $userId, int $productId, int $amount)
    {
        $stmt = static::getPDO()->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function updateProducts(int $amount, int $userId, int $productId)
    {
        $stmt = static::getPDO()->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId and product_id = :productId");
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

    public function setProduct(Product $product): void
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