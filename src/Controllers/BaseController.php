<?php

namespace Controllers;

use Model\User;
use Service\AuthService;

class BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }
}