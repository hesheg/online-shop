<?php

namespace Controllers;

use Model\Product;
use Model\UserProduct;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }

    public function getCatalogPage()
    {
        require_once '../Views/catalog_page.php';
    }

    public function getCatalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $products = $this->productModel->getAll();

        require_once '../Views/catalog_page.php';
    }

    public function addProduct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $errors = $this->validateAddProduct($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product-id'];
            $amount = 1;
            $result = $this->userProductModel->getByProdIdAndUserId($productId, $userId);

            if ($result === null) {
                $this->userProductModel->insertProducts($userId, $productId, $amount);
            } else {
                $amount += $result->getAmount();

                $this->userProductModel->updateProducts($amount, $userId, $productId);
            }

            header("Location: /catalog");
        }
    }


    public function decreaseProduct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $errors = $this->validateAddProduct($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product-id'];
            $result = $this->userProductModel->getByProdIdAndUserId($productId, $userId);

            if ($result !== null) {
                if ($result->getAmount() === 1) {
                    $result->deleteByUserId($userId);
                }
                $amount = $result->getAmount() - 1;

                $this->userProductModel->updateProducts($amount, $userId, $productId);
            }

            header("Location: /catalog");
        }
    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product-id'])) {
            $productId = (int)$data['product-id'];

            $data = $this->productModel->getOneById($productId);

            if ($data === null) {
                $errors['product-id'] = 'Продукт не найден';
            }
        } else {
            $errors['product-id'] = 'id продукта должен быть указан';
        }

//        if (!isset($data['amount'])) {
//            $errors['amount'] = 'Укажите количество добавляемого продукта';
//        }

        return $errors;
    }


}