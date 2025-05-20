<?php

namespace DTO;

use http\Encoding\Stream\Inflate;

class AddReviewDTO
{
    public function __construct(
        private int $productId,
        private int $rating,
        private string $comment
    ){
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
}