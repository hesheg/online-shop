<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $sum;

    private function createObj(array|false $user): self|null
    {
        if (!$user) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->orderId = $user['order_id'];
        $obj->productId = $user['product_id'];
        $obj->amount = $user['amount'];

        return $obj;
    }

    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO order_products (order_id, product_id, amount) 
                    VALUES (:orderId, :productId, :amount)"
        );

        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getAllByOrderId(int $orderId): array|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        $result = [];
        foreach ($orderProducts as $orderProduct) {
            $obj = $this->createObj($orderProduct);
                $result[] = $obj;
            }

        return $result;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
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

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}