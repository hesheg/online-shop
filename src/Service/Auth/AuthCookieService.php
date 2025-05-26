<?php

namespace Service\Auth;

use DTO\AuthDTO;
use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if ($this->check()) {
            $userId = $_COOKIE['user_id'];

            return User::getById($userId);
        } else {
            return null;
        }
    }

    public function auth(AuthDTO $data): bool
    {
        $user = User::getByEmail($data->getEmail());

        if (!$user) {
            return false;
        } else {
            $passwordDb = $user->getPassword();

            if (password_verify($data->getPassword(), $passwordDb)) {
                setcookie('user_id', $user->getId());

                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        setcookie('user_id', '', time() - 3600, '/');
        unset($_COOKIE['user_id']);
    }
}