<?php

namespace Model;


class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $rating;
    private string $comment;
    private string $createdAt;
    private User $user;


    public function create(int $userId, int $productId, int $rating, string $comment, string $created_at)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} 
                    (user_id, product_id, rating, comment, created_at) 
                    VALUES (:user_id, :product_id, :rating, :comment, :created_at)");

        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'comment' => $comment,
            'created_at' => $created_at
        ]);
    }

    public function getAllByProdId($productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);
        $reviews = $stmt->fetchAll();

        $result = [];
        foreach ($reviews as $review) {
            $obj = $this->createObj($review);
            $result[] = $obj;
        }

        return $result;
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
        $obj->rating = $user['rating'];
        $obj->comment = $user['comment'];
        $obj->createdAt = $user['created_at'];

        return $obj;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


    protected function getTableName(): string
    {
        return 'reviews';
    }

//    public function getId(): int
//    {
//        return $this->data['id'];
//    }
//
//    public function getUserId(): int
//    {
//        return $this->data['user_id'];
//    }
//
//    public function getProductId(): int
//    {
//        return $this->data['product_id'];
//    }
//
//    public function getRating(): int
//    {
//        return $this->data['rating'];
//    }
//
//    public function getComment(): string
//    {
//        return $this->data['comment'];
//    }
//
//    public function getCreatedAt(): string
//    {
//        return $this->data['created_at'];
//    }
}