<?php

namespace Service\Auth;

use DTO\AuthDTO;
use Model\User;

class AuthSessionService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function check(): bool
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        $this->startSession();

        if ($this->check()) {
            $userId = $_SESSION['user_id'];

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
                $this->startSession();
                $_SESSION['user_id'] = $user->getId();

                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        $this->startSession();
        session_destroy();
    }

    protected function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}