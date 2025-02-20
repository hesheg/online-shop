<?php

class App
{
    private array $routes = [

        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrateForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',
            ],
        ],

        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ],
        ],

        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'profile',
            ],
        ],

        '/edit-profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditProfileForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile',
            ],
        ],

        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'getCatalogPage',
            ],
        ],

        '/add-product' => [
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct',
            ],
        ],

        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'cart',
            ],
        ],

        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout',
            ],
        ],
    ];


    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                require_once "../Controllers/$class.php";
                $controller = new $class();
                $controller->$method();
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }
    }
}