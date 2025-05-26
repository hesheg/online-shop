<?php

namespace Request;

use Model\Product;

class AddProductRequest
{
    private Product $productModel;
    public function __construct(private array $data)
    {
        $this->productModel = new Product();
    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];

            $product = Product::getOneById($productId);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        } else {
            $errors['product_id'] = 'id продукта должен быть указан';
        }

        return $errors;
    }
}