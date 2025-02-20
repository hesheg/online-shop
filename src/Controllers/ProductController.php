<?php

class ProductController
{
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

        require_once '../Model/Product.php';
        $productModel = new Product();
        $products = $productModel->getProducts();

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
            $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product-id'];
            $amount = $_POST['amount'];

            require_once '../Model/Product.php';
            $productModel = new Product();
            $result = $productModel->getProdByProdIdAndUserId($productId, $userId);

            if ($result === false) {
                $productModel->insertProducts($userId, $productId, $amount);
            } else {
                $amount = $amount + $result['amount'];

                $productModel->updateProducts($amount, $userId, $productId);
            }

            header("Location: /catalog");
        }
    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product-id'])) {
            $productId = (int)$data['product-id'];

            require_once '../Model/Product.php';
            $productModel = new Product();
            $data = $productModel->getById($productId);

            if ($data === false) {
                $errors['product-id'] = 'Продукт не найден';
            }
        } else {
            $errors['product-id'] = 'id продукта должен быть указан';
        }

        if (isset($data['amount'])) {
            if ($data['amount'] <= 0) {
                $errors['amount'] = 'Количество продуктов должно быть больше 0';
            }
        }

        return $errors;
    }


}