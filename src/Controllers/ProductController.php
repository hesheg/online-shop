<?php

namespace Controllers;

use Model\Product;
use Service\CartService;

class ProductController extends BaseController
{
    private Product $productModel;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->cartService = new CartService();

    }

    public function getCatalogPage()
    {
        require_once '../Views/catalog_page.php';
    }

    public function getCatalog()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $products = $this->productModel->getAll();


        require_once '../Views/catalog_page.php';
    }

    public function addProduct()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $data = $_POST;
        $user = $this->authService->getCurrentUser();
        $errors = $this->validateAddProduct($data);

        if (empty($errors)) {
            $this->cartService->addProduct($data['product_id'], $user->getId(), $data['amount']);
            header("Location: /catalog");
        } else {
            print_r($errors);
            exit;
        }
    }


    public function decreaseProduct()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $data = $_POST;
        $user = $this->authService->getCurrentUser();
        $errors = $this->validateAddProduct($data);

        if (empty($errors)) {
            $this->cartService->decreaseProduct($data['product_id'], $user->getId(), $data['amount']);
            header("Location: /catalog");
        } else {
            print_r($errors);
            exit;
        }
    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = $data['product_id'];

            $product = $this->productModel->getOneById($productId);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        } else {
            $errors['product_id'] = 'id продукта должен быть указан';
        }

        return $errors;
    }


}