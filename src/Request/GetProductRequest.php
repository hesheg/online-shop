<?php

namespace Request;

class GetProductRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId()
    {
        return $this->data['product_id'];
    }
}