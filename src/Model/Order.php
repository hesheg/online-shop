<?php

namespace Model;

class Order extends Model
{
    private int $id;
    private string $contact_name;
    private int $contact_phone;
    private string|null $comment;
    private int $userId;
    private string $address;
    private int $total;
    private array $orderProducts;


    protected function getTableName(): string
    {
        return 'orders';
    }

    private function createObj(array|false $user): self|null
    {
        if (!$user) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->contact_name = $user['contact_name'];
        $obj->contact_phone = $user['contact_phone'];
        $obj->comment = $user['comment'];
        $obj->userId = $user['user_id'];
        $obj->address = $user['address'];

        return $obj;
    }

    public function create(
        string $contactName,
        string $contactPhone,
        string $address,
        string $comment,
        int $userId
    ){
       $stmt = $this->pdo->prepare(
           "INSERT INTO {$this->getTableName()} (contact_name, contact_phone, comment, user_id, address) 
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

    public function getAllByUserId(int $userId): array|null
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->getTableName()} 
         WHERE user_id = :user_id 
         ORDER BY id DESC"
        );

        $stmt->execute(['user_id' => $userId]);
        $orders = $stmt->fetchAll();

        $result = [];
        foreach ($orders as $order) {
            $obj = $this->createObj($order);
            $result[] = $obj;
        }
        return $result;
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    public function setOrderProducts(array $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $totalSum): void
    {
        $this->total = $totalSum;
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