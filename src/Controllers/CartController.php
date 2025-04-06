<?php

namespace Controllers;
use Model\Product;
use Model\UserProduct;

class CartController extends BaseController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }
    public function cart()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $products = [];
        $sum = 0;
        $user = $this->authService->getCurrentUser();
        $userProducts = $this->userProductModel->getAllByUserId($user->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();

            $product = $this->productModel->getOneById($productId);
            $totalSum = $userProduct->getAmount() * $product->getPrice();
            $product->setSum($totalSum);
            $userProduct->setProduct($product);
            $sum += $userProduct->getProduct()->getSum();

            $products[] = $userProduct;
        }


        require_once '../Views/cart_page.php';
    }
}