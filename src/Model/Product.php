<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;
    private int $sum;

    private function createObj(array|false $user): self|null
    {
        if (!$user) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->price = $user['price'];
        $obj->description = $user['description'];
        $obj->image_url = $user['image_url'];

        return $obj;
    }

    public function getAll(): array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll();

        $result = [];
        foreach ($products as $product) {
            $obj = $this->createObj($product);
            $result[] = $obj;
        }

        return $result;
    }

    public function getOneById(int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $product = $stmt->fetch();

        return $this->createObj($product);
    }

    //    public function getById($userProducts): array|null
//    {
//        $products = [];
//        $result = [];
//
//        foreach ($userProducts as $userProduct) {
//            $productId = $userProduct['product_id'];
//            $stmt = $this->pdo->query("SELECT * FROM products WHERE id = $productId");
//            $product = $stmt->fetch();
//            $product['amount'] = $userProduct['amount'];
//            $products[] = $product;
//
//            foreach ($products as $product) {
//                $obj = $this->createObj($product);
//                $result[] = $obj;
//            }
//        }
//        return $result;
//    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}