<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;

require_once './../Core/Autoloader.php';

$dir = dirname(__DIR__);
\Core\Autoloader::register($dir);

$app = new App();

$app->get('/registration', UserController::class, 'getRegistrateForm');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrateRequest::class);
$app->get('/login', UserController::class, 'getLoginForm');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);
$app->get('/profile', UserController::class, 'profile');
$app->post('/profile', UserController::class, 'profile');
$app->get('/edit-profile', UserController::class, 'getEditProfileForm');
$app->post('/edit-profile', UserController::class, 'editProfile', \Request\EditProfileRequest::class);
$app->get('/logout', UserController::class, 'logout');


$app->get('/cart', CartController::class, 'cart');
$app->post('/add-product', CartController::class, 'addProduct', \Request\AddProductRequest::class);
$app->post('/decrease-product', CartController::class, 'decreaseProduct', \Request\DecreaseProductRequest::class);


$app->get('/catalog',  ProductController::class, 'getCatalog');
$app->post('/catalog', ProductController::class, 'getCatalogPage');
$app->get('/review',  ProductController::class, 'getReview');
$app->post('/review-add',  ProductController::class, 'addReview', \Request\AddReviewRequest::class);
$app->post('/get-product',  ProductController::class, 'getProduct', \Request\GetProductRequest::class);


$app->get('/create-order',OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout', \Request\HandleCheckoutRequest::class);
$app->get('/user-order', OrderController::class, 'getAllOrders');

$app->run();
