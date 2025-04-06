<?php

namespace Controllers;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController extends BaseController
{
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;
    private Order $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
        $this->orderModel = new Order();
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

//        $newUserOrders = [];
//        $newOrderProducts = [];
        $total = 0;
        foreach ($userOrders as $userOrder) {
            $orderId = $userOrder->getId();
            $orderProducts = $this->orderProductModel->getAllByOrderId($orderId);

//            echo "<pre>";
//            print_r($orderProducts); die;
            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getOneById($orderProduct->getProductId());

                $sum = $product->getPrice() * $orderProduct->getAmount();
                $orderProduct->setProduct($product);
                $orderProduct->setSum($sum);
                $total += $orderProduct->getSum();

//                $newOrderProducts[] = $orderProduct;
            }

            $userOrder->setTotal($total);
            $total = 0;
            $userOrder->setOrderProducts($orderProducts);
//            echo "<pre>";
//            print_r($userOrder); die;
//            $newUserOrders[] = $userOrder;
        }

        require_once '../Views/user_orders.php';
    }


    public function getCheckoutForm()
    {
        require_once '../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];
            $address = $_POST['address'];
            $comment = $_POST['comment'];
            $user = $this->authService->getCurrentUser();

            $orderId = $this->orderModel->create($contactName, $contactPhone, $address, $comment, $user->getId());

            $userProducts = $this->userProductModel->getAllByUserId($user->getId());

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $this->orderProductModel->create($orderId, $productId, $amount);
            }

            $this->userProductModel->deleteByUserId($user->getId());

            header("Location: /user-order");
            exit;
        } else {
            require_once '../Views/order_form.php';
        }
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (isset($data['contact_name'])) {
            $name = $data['contact_name'];

            if (strlen($name) < 2 || strlen($name) > 40) {
                $errors['contact_name'] = 'В имени должно быть от 2 до 40 символов';
            } elseif (!ctype_alpha($name)) {
                $errors['contact_name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }

        if (isset($data['contact_phone'])) {
            $phone = $data['contact_phone'];

            if (is_numeric($phone)) {
                if (strlen($phone) < 11) {
                    $errors['contact_phone'] = 'Количество символов в номере должно быть больше 9';
                } elseif (!str_contains($phone, '+7')) {
                    $errors['contact_phone'] = 'Номер должен начинаться на "+7"';
                }
            } else {
                $errors['contact_phone'] = 'Номер должен состоять из цифр';
            }
        }


        if (empty($data['address'])) {
            $errors['address'] = 'Введите адрес доставки';
        } else {
            $address = $_POST['address'];
        }

        return $errors;
    }
}