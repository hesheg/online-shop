<?php

namespace Request;

use Model\User;

class LoginRequest
{
    private User $userModel;

    public function __construct(private array $data)
    {
        $this->userModel = new User();
    }


    public function validate(): array
    {
        $errors = [];

        if (!isset ($this->data['username'])) {
            $errors['username'] = 'Поле username обязательно для заполнения';
        }

        if (!isset ($this->data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }

        return $errors;
    }
}