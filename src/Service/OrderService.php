<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService extends BaseService
{
    private AuthInterface $authService;
    private CartService $cartService;


    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function create(OrderCreateDTO $data): void
    {
        $sum = $this->cartService->getSum();

        if ($sum < 1000) {
            throw new \Exception('для оформления заказа, сумма корзины должна быть больше 1000');
        }

        $user = $this->authService->getCurrentUser();
        $userProducts = UserProduct::getAllByUserId($user->getId());

        $orderId = Order::create(
            $data->getName(),
            $data->getPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            OrderProduct::create($orderId, $productId, $amount);
        }

        UserProduct::deleteByUserId($user->getId());
    }

    public function getAll()
    {
        $user = $this->authService->getCurrentUser();
        $orders = Order::getAllByUserId($user->getId());

        foreach ($orders as $order) {
            $orderProducts = OrderProduct::getAllByOrderIdWithProducts($order->getId());
//            $this->echoPre($orderProducts);
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
                $itemSum = $orderProduct->getAmount() * $orderProduct->getProduct()->getPrice();
                $orderProduct->setSum($itemSum);

                $sum += $itemSum;
            }

            $order->setOrderProducts($orderProducts);
            $order->setTotalSum($sum);
        }

//        foreach ($orders as $order) {
//            $sum = 0;
//
//            $itemSum = $order->getOrderProducts()->getAmount() * $order->getProduct()->getPrice();
//            $sum += $itemSum;
//
//            $order->setTotalSum($sum);
//        }
//        $this->echoPre($orders);

        return $orders;
    }
}