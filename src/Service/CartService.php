<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\Product;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    private AuthService $authService;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->productModel = new Product();
    }

    public function addProduct(AddProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $result = $this->userProductModel->getByProdIdAndUserId($data->getProductId(), $user->getId());

        if ($result === null) {
            $this->userProductModel->insertProducts($user->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $amount = $data->getAmount();
            $amount += $result->getAmount();

            $this->userProductModel->updateProducts($amount, $user->getId(), $data->getProductId());
        }
    }

    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $result = $this->userProductModel->getByProdIdAndUserId($data->getProductId(), $user->getId());

        if ($result) {
            if ($result->getAmount() === 1) {
                $result->deleteByUserIdAndProdId($user->getId(), $data->getProductId());
            }
            $amount = $result->getAmount() - 1;

            $this->userProductModel->updateProducts($amount, $user->getId(), $data->getProductId());
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null) {
            return [];
        }

        $userProducts = $this->userProductModel->getAllByUserId($user->getId());
        foreach ($userProducts as $userProduct)
        {
            $product = $this->productModel->getOneById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotalSum($totalSum);
        }

        return $userProducts;
    }

    public function getSum(): int
    {
        $sum = 0;

        foreach ($this->getUserProducts() as $userProduct)
        {
            $sum += $userProduct->getTotalSum();
        }

        return $sum;
    }
}