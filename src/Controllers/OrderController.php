<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\HandleCheckoutRequest;
use Service\OrderService;

class OrderController extends BaseController
{
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private Order $orderModel;
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
        $this->orderService = new OrderService();
    }


    public function getUserOrderForm()
    {
        require_once '../Views/user_orders.php';
    }

    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $user = $this->authService->getCurrentUser();
        $userOrders = $this->orderModel->getAllByUserId($user->getId());

        if (empty($userOrders)) {
            echo 'Вы еще не совершили первый заказ';
        }

        $total = 0;
        foreach ($userOrders as $userOrder) {
            $orderId = $userOrder->getId();
            $orderProducts = $this->orderProductModel->getAllByOrderId($orderId);

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getOneById($orderProduct->getProductId());

                $sum = $product->getPrice() * $orderProduct->getAmount();
                $orderProduct->setProduct($product);
                $orderProduct->setSum($sum);
                $total += $orderProduct->getSum();
            }

            $userOrder->setTotal($total);
            $total = 0;
            $userOrder->setOrderProducts($orderProducts);
        }

        require_once '../Views/user_orders.php';
    }


    public function getCheckoutForm()
    {
        require_once '../Views/order_form.php';
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