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


    public static function create(int $userId, int $productId, int $rating, string $comment, string $created_at)
    {
        $stmt = static::getPDO()->prepare(
            "INSERT INTO reviews 
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

    public static function getAllByProdId($productId): array|false
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);
        $reviews = $stmt->fetchAll();

        $result = [];
        foreach ($reviews as $review) {
            $obj = static::createObj($review);
            $result[] = $obj;
        }

        return $result;
    }

    public static function createObj(array|false $review): self|null
    {
        if (!$review) {
            return null;
        }

        $obj = new self();
        $obj->id = $review['id'];
        $obj->userId = $review['user_id'];
        $obj->productId = $review['product_id'];
        $obj->rating = $review['rating'];
        $obj->comment = $review['comment'];
        $obj->createdAt = $review['created_at'];

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
}