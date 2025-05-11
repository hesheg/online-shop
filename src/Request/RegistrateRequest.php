<?php

namespace Request;

use Model\User;

class RegistrateRequest
{
    private User $userModel;

    public function __construct(private array $data)
    {
        $this->userModel = new User();
    }


    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['psw'];
    }


    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];

            if (strlen($name) < 2 || strlen($name) > 40) {
                $errors['name'] = 'В имени должно быть от 2 до 40 символов';
            } elseif (!ctype_alpha($name)) {
                $errors['name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            $emailToLower = strtolower($email);
            $email = trim($emailToLower);

            $userModel = $this->userModel;

            if (strlen($email) < 5) {
                $errors['email'] = 'Количество символов в email должно быть больше 5';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'В email обязательно должны быть символы "@" и "."';
            } else {
                $result = $userModel->getByEmail($email);

                if ($result !== null) {
                    $errors['email'] = 'Пользователь с таким email уже существует';
                }
            }
        } else {
            $errors['email'] = 'Поле email должно быть заполнено';
        }


        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];

            if (strlen($password) < 8 || strlen($password) > 20) {
                $errors['psw'] = 'Длина пароля должна быть от 8 до 20 символов';
            }
            $passwordRep = $this->data['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }

        return $errors;
    }
}