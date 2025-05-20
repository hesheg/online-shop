<?php

namespace Request;

use Model\User;
use Service\AuthService;

class EditProfileRequest
{
    private User $userModel;
    private AuthService $authService;

    public function __construct(private array $data)
    {
        $this->userModel = new User();
        $this->authService = new AuthService();
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function getEmail()
    {
        return $this->data['email'];
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
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            $emailToLower = strtolower($email);
            $email = trim($emailToLower);

            if (strlen($email) < 5) {
                $errors['email'] = 'Количество символов в email должно быть больше 5';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'В email обязательно должны быть символы "@" и "."';
            } else {
                $userDb = $this->userModel->getByEmail($email);
                $user = $this->authService->getCurrentUser();

                if ($userDb === null) {
                    echo '';
                } elseif ($userDb->getId() !== $user->getId()) {
                    $errors['email'] = 'Пользователь с таким email уже существует';
                }
            }
        }
        return $errors;
    }
}