<?php

namespace Service;

use DTO\AddReviewDTO;
use Model\Review;

class ReviewService extends BaseService
{
    private Review $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new Review();
    }
    public function addReview(int $userId, AddReviewDTO $data, string $createdAt)
    {
            Review::create(
                $userId,
                $data->getProductId(),
                $data->getRating(),
                $data->getComment(),
                $createdAt
            );
    }
}