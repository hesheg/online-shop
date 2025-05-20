<?php

namespace Controllers;

use DTO\AddReviewDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\Review;
use Model\User;
use Request\AddReviewRequest;
use Request\GetProductRequest;
use Service\ReviewService;

class ProductController extends BaseController
{
    private Product $productModel;
    private Review $reviewModel;
    private User $userModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private ReviewService $reviewService;


    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->reviewModel = new Review();
        $this->userModel = new User();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->reviewService = new ReviewService();
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

    public function addReview(AddReviewRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $errors = $request->validate();

        if (!empty($errors)) {
            print_r($errors);
            exit();
        }

        $userId = $this->authService->getCurrentUser()->getId();
        $createdAt = date("Y-m-d H:i:s");
        $dto = new AddReviewDTO(
            $request->getProductId(),
            $request->getRating(),
            $request->getComment()
        );

        $this->reviewService->addReview($userId, $dto, $createdAt);
        header("Location: /catalog");
    }

    public function getProduct(GetProductRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $userOrders = $this->orderModel->getAllByUserId($user->getId());

        $product = $this->productModel->getOneById($request->getProductId());
        $reviews = $this->reviewModel->getAllByProdId($request->getProductId());

        $ratingTotal = 0;
        $count = 0;

        if (empty($reviews)) {
            $ratingTotal += 0;
        } else {
            $count = count($reviews);
            $rating = 0;

            foreach ($reviews as $review) {
                $review->setUser($this->userModel->getById($review->getUserId()));
                $rating += $review->getRating();
                $ratingTotal = round($rating / $count, 1);
            }
        }

        $result = false;

        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());
            foreach ($orderProducts as $orderProduct) {
                if ($orderProduct->getProductId() === $product->getId()) {
                    $result = true;
                }
            }
        }

        require_once '../Views/review_form.php';
    }
}