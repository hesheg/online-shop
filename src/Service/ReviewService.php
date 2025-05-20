<?php

namespace Service;

use DTO\AddReviewDTO;
use Model\Review;

class ReviewService
{
    private Review $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review();
    }
    public function addReview(int $userId, AddReviewDTO $data, string $createdAt)
    {
            $this->reviewModel->create(
                $userId,
                $data->getProductId(),
                $data->getRating(),
                $data->getComment(),
                $createdAt
            );
    }
}