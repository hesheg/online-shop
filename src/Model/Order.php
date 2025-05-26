<?php

namespace Model;

use PDO;

class Order extends Model
{
    private int $id;
    private string $contact_name;
    private int $contact_phone;
    private string|null $comment;
    private int $userId;
    private string $address;
    private int $totalSum;
    private array $orderProducts;
//    private Product $product;

    public static function createObj(array|false $order): self|null
    {
        if (!$order) {
            return null;
        }

        $obj = new self();
        $obj->id = $order['id'];
        $obj->contact_name = $order['contact_name'];
        $obj->contact_phone = $order['contact_phone'];
        $obj->comment = $order['comment'];
        $obj->userId = $order['user_id'];
        $obj->address = $order['address'];

        return $obj;
    }

//    public static function createObjWithProduct(array|false $order): self|null
//    {
//        $obj = static::createObj($order);
//
//        $dataOrderProduct = [
//            'id' => $order['order_product_id'],
//            'order_id' => $order['order_id'],
//            'product_id' => $order['product_id'],
//            'amount' => $order['amount'],
//        ];
//
//        $orderProduct = OrderProduct::createObj($dataOrderProduct);
//        $obj->setOrderProducts($orderProduct);
//
//        $dataProduct = [
//            'id' => $order['id'],
//            'name' => $order['name'],
//            'description' => $order['description'],
//            'price' => $order['price'],
//            'image_url' => $order['image_url']
//        ];
//
//        $product = Product::createObj($dataProduct);
//        $obj->setProduct($product);
//
//        return $obj;
//    }

    public static function create(
        string $contactName,
        string $contactPhone,
        string $address,
        string $comment,
        int    $userId
    )
    {
        $stmt = static::getPDO()->prepare(
            "INSERT INTO orders (contact_name, contact_phone, comment, user_id, address) 
                    VALUES (:name, :phone, :comment, :user_id, :address) RETURNING  id"
        );
        $stmt->execute([
            'name' => $contactName,
            'phone' => $contactPhone,
            'comment' => $comment,
            'address' => $address,
            'user_id' => $userId
        ]);

        $data = $stmt->fetch();
        return $data['id'];
    }

    public static function getAllByUserId(int $userId): array|null
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM orders WHERE user_id = :user_id 
         ORDER BY id DESC");

        $stmt->execute(['user_id' => $userId]);
        $orders = $stmt->fetchAll();

        $result = [];
        foreach ($orders as $order) {
            $obj = static::createObj($order);
            $result[] = $obj;
        }
        return $result;
    }

//    public static function getAllWithProductsByUserId(int $userId): array|null
//    {
//        $stmt = static::getPDO()->prepare("SELECT
//        o.id,
//        o.contact_name,
//        o.contact_phone,
//        o.comment,
//        o.user_id,
//        o.address,
//
//        op.id AS order_product_id,
//        op.order_id,
//        op.product_id AS product_id_from_op,
//        op.amount,
//
//        p.id AS product_id,
//        p.name,
//        p.description,
//        p.price,
//        p.image_url
//                FROM orders o
//                 INNER JOIN order_products op ON o.id = op.order_id
//                 INNER JOIN products p ON op.product_id = p.id
//                 WHERE o.user_id = :user_id
//                 ORDER BY o.id DESC");
//        $stmt->execute(['user_id' => $userId]);
//        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//        $result = [];
//        foreach ($orders as $order) {
//            $obj = static::createObjWithProduct($order);
//            $result[] = $obj;
//        }
//        self::echoPre($result);
//        return $result;
//    }

//    public function getProduct(): Product
//    {
//        return $this->product;
//    }
//
//    public function setProduct(Product $product): void
//    {
//        $this->product = $product;
//    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    public function setOrderProducts(array $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }

    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getContactPhone(): int
    {
        return $this->contact_phone;
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getComment(): string|null
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}