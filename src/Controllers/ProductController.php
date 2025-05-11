<?php

namespace Controllers;

use Model\Product;
use Request\AddProductRequest;
use Request\DecreaseProductRequest;
use Service\CartService;

class ProductController extends BaseController
{
    private Product $productModel;


    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
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
}