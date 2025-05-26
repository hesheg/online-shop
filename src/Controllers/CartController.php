<?php

namespace Controllers;
use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class CartController extends BaseController
{
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();
    }

    public function addProduct(AddProductRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $errors = $request->validate();

        if (empty($errors)) {
            $dto = new AddProductDTO($request->getProductId(), $request->getAmount());
            $this->cartService->addProduct($dto);
//            header("Location: /catalog");
            header('Location: ' . $_SERVER['HTTP_REFERER']);
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

        $errors = $request->validate();

        if (empty($errors)) {
            $dto = new DecreaseProductDTO($request->getProductId());
            $this->cartService->decreaseProduct($dto);
//            header("Location: /catalog");
            header('Location: ' . $_SERVER['HTTP_REFERER']);
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

        $userProducts = $this->cartService->getUserProducts();
        $sum = $this->cartService->getSum();

        require_once '../Views/cart_page.php';
    }
}