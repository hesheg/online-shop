<?php

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class BaseController
{
    protected AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

    public function echoPre($value)
    {
        echo "<pre>";
        print_r($value);
        die;
    }
}