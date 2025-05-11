<?php

namespace Controllers;
use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class CartController extends BaseController
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->cartService = new CartService();
    }

    public function addProduct(AddProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $user = $this->authService->getCurrentUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $this->cartService->addProduct($request->getProductId(), $user->getId(), $request->getAmount());
            header("Location: /catalog");
        } else {
            print_r($errors);
            exit;
        }
    }

    public function decreaseProduct(DecreaseProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $user = $this->authService->getCurrentUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $this->cartService->decreaseProduct($request->getProductId(), $user->getId(), $request->getAmount());
            header("Location: /catalog");
        } else {
            print_r($errors);
            exit;
        }
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