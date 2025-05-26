<?php

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService extends BaseService
{
    private AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

    public function addProduct(AddProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $result = UserProduct::getByProdIdAndUserId($data->getProductId(), $user->getId());

        if ($result === null) {
            UserProduct::insertProducts($user->getId(), $data->getProductId(), $data->getAmount());
        } else {
            $amount = $data->getAmount();
            $amount += $result->getAmount();

            UserProduct::updateProducts($amount, $user->getId(), $data->getProductId());
        }
    }

    public function decreaseProduct(DecreaseProductDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $result = UserProduct::getByProdIdAndUserId($data->getProductId(), $user->getId());

        if ($result) {
            if ($result->getAmount() === 1) {
                $result->deleteByUserIdAndProdId($user->getId(), $data->getProductId());
            }
            $amount = $result->getAmount() - 1;

            UserProduct::updateProducts($amount, $user->getId(), $data->getProductId());
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null) {
            return [];
        }

        $userProducts = UserProduct::getAllByUserId($user->getId());
        $this->echoPre($userProducts);
        foreach ($userProducts as $userProduct)
        {
//            $product = Product::getOneById($userProduct->getProductId());
//            $userProduct->setProduct($product);
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