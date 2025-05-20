<?php

namespace Request;


class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getEmail()
    {
        return $this->data['username'];
    }

    public function getPassword()
    {
        return $this->data['password'];
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