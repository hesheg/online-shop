<?php

namespace Controllers;
use Model\Product;
use Model\UserProduct;

class CartController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }
    public function cart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $products = [];
        $sum = 0;
        $userId = $_SESSION['user_id'];
        $userProducts = $this->userProductModel->getAllByUserId($userId);

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