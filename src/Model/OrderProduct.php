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

    public static function createObj(array|false $orderProduct): self|null
    {
        if (!$orderProduct) {
            return null;
        }

        $obj = new self();
        $obj->id = $orderProduct['id'];
        $obj->orderId = $orderProduct['order_id'];
        $obj->productId = $orderProduct['product_id'];
        $obj->amount = $orderProduct['amount'];

        return $obj;
    }

    public static function createObjWithProducts(array|false $orderProduct): self|null
    {
        $obj = static::createObj($orderProduct);

        $dataProduct = [
            'id' => $orderProduct['product_id'],
            'name' => $orderProduct['name'],
            'description' => $orderProduct['description'],
            'price' => $orderProduct['price'],
            'image_url' => $orderProduct['image_url']
        ];
        $product = Product::createObj($dataProduct);
        $obj->setProduct($product);

        return $obj;
    }

    public static function create(int $orderId, int $productId, int $amount)
    {
        $stmt = static::getPDO()->prepare(
            "INSERT INTO order_products (order_id, product_id, amount) 
                    VALUES (:orderId, :productId, :amount)"
        );

        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function getAllByOrderIdWithProducts(int $orderId): array|null
    {
        $stmt = static::getPDO()->prepare("SELECT * 
        FROM order_products op INNER JOIN products p ON op.product_id = p.id
        WHERE order_id = :orderId");

        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        $result = [];
        foreach ($orderProducts as $orderProduct) {
            $obj = static::createObjWithProducts($orderProduct);
                $result[] = $obj;
            }

        return $result;
    }

    public function setProduct(Product $product): void
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