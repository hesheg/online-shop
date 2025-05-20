<?php

namespace Request;

class AddReviewRequest
{
    public function __construct(private array $data)
    {
    }

    public function getId():int
    {
        return $this->data['id'];
    }
    public function getUserId():int
    {
        return $this->data['user_id'];
    }

    public function getProductId():int
    {
        return $this->data['product_id'];
    }

    public function getRating():int
    {
        return $this->data['rating'];
    }
    public function getComment():string
    {
        return $this->data['comment'];
    }

    public function validate(): array | null
    {
        $errors = [];

        if (isset($this->data['comment'])) {
            $comment = $this->data['comment'];

            if (strlen($comment) < 10 || strlen($comment) > 255) {
                $errors['comment'] = 'длина отзыва должна быть больше 10 и меньше 255 символов';
            }
        }

        if (isset($this->data['rating'])) {
            $rating = $this->data['rating'];

            if (!is_numeric($rating)) {
                $errors['rating'] = 'оценка должна быть цифренным значением';
            } elseif ($rating < 1 || $rating > 5) {
                $errors['rating'] = 'оценка должна быть от 1 до 5';
            }
        } else {
            $errors['rating'] = 'укажите оценку';
        }

        return $errors;
    }
}