<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Request\HandleCheckoutRequest;
use Service\CartService;
use Service\OrderService;

class OrderController extends BaseController
{
    private OrderService $orderService;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }

    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $userOrders = $this->orderService->getAll();
//        $this->echoPre($userOrders);

        require_once '../Views/user_orders.php';
    }


    public function getCheckoutForm()
    {
        if ($this->authService->check()) {
            $userProducts = $this->cartService->getUserProducts();
            if (empty($userProducts)) {
                header('Location: /catalog');
                exit;
            }

            $total = $this->cartService->getSum();
            require_once '../Views/order_form.php';
        } else {
            header('Location: /login');
            exit;
        }
    }

    public function handleCheckout(HandleCheckoutRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $errors = $request->validate();
        $user = $this->authService->getCurrentUser();

        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getName(),
                $request->getPhone(),
                $request->getComment(),
                $request->getAddress(),
            );

            $this->orderService->create($dto);
            header("Location: /user-order");
            exit;
        } else {
            require_once '../Views/order_form.php';
        }
    }
}