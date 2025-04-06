<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function addProduct(int $productId, int $userId, int $amount)
    {
        $result = $this->userProductModel->getByProdIdAndUserId($productId, $userId);

        if ($result === null) {
            $this->userProductModel->insertProducts($userId, $productId, $amount);
        } else {
            $amount += $result->getAmount();

            $this->userProductModel->updateProducts($amount, $userId, $productId);
        }
    }

    public function decreaseProduct(int $productId, int $userId, int $amount)
    {
        $result = $this->userProductModel->getByProdIdAndUserId($productId, $userId);

        if ($result) {
            if ($result->getAmount() === 1) {
                $result->deleteByUserIdAndProdId($userId, $productId);
            }
            $amount = $result->getAmount() - 1;

            $this->userProductModel->updateProducts($amount, $userId, $productId);
        }

    }
}