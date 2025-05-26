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
    private int $amount;


    public static function createObj(array|false $product): self|null
    {
        if (!$product) {
            return null;
        }

        $obj = new self();

        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->price = $product['price'];
        $obj->description = $product['description'];
        $obj->image_url = $product['image_url'];

        return $obj;
    }

    public static function getAll(): array|false
    {
        $stmt = static::getPDO()->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        $result = [];
        foreach ($products as $product) {
            $obj = static::createObj($product);
            $result[] = $obj;
        }

        return $result;
    }

    public static function getOneById(int $productId): self|null
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);
        $product = $stmt->fetch();

        return static::createObj($product);
    }


    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
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