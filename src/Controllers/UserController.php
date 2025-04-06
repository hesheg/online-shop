<?php

namespace Controllers;

use Model\User;

class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    public function getRegistrateForm()
    {
        require_once '../Views/registration_form.php';
    }

    public function registrate()
    {
        $errors = $this->validateRegistration($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-repeat'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($name, $email, $password);

            header("Location: /login");
            exit;
        }

        require_once '../Views/registration_form.php';
    }

    private function validateRegistration(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];

            if (strlen($name) < 2 || strlen($name) > 40) {
                $errors['name'] = 'В имени должно быть от 2 до 40 символов';
            } elseif (!ctype_alpha($name)) {
                $errors['name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($data['email'])) {
            $email = $data['email'];

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


        if (isset($data['psw'])) {
            $password = $_POST['psw'];

            if (strlen($password) < 8 || strlen($password) > 20) {
                $errors['psw'] = 'Длина пароля должна быть от 8 до 20 символов';
            }
            $passwordRep = $_POST['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }

        return $errors;
    }


    public function getLoginForm()
    {
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        $data = $_POST;
        $errors = $this->validateLogin($data);

        if (empty($errors)) {
            $result = $this->authService->auth($data['username'], $data['password']);


            if ($result === true) {
                header("Location: /profile");
                exit;
            } else {
                $errors['username'] = 'username or password incorrect';
            }
        }
        return require_once '../Views/login_form.php';
    }


    private function validateLogin(array $data): array
    {
        $errors = [];

        if (!isset ($data['username'])) {
            $errors['username'] = 'Поле username обязательно для заполнения';
        }

        if (!isset ($data['password'])) {
            $errors['password'] = 'Поле password обязательно для заполнения';
        }

        return $errors;
    }


    public function profile()
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            $user = $this->userModel->getById($user->getId());

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");
            exit;
        }
    }

    public function getEditProfileForm()
    {
        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $this->validateEditProfile($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $user = $this->authService->getCurrentUser();

            $user = $this->userModel->getById($user->getId());

            if ($name !== $user->getName()) {
                $this->userModel->updateNameById($name, $user->getId());
            }

            if ($email !== $user->getEmail()) {
                $this->userModel->updateEmailById($email, $user->getId());
            }

            header("Location: /profile");
            exit;
        }
        require_once '../Views/edit_profile_form.php';
    }

    private function validateEditProfile(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];

            if (strlen($name) < 2 || strlen($name) > 40) {
                $errors['name'] = 'В имени должно быть от 2 до 40 символов';
            } elseif (!ctype_alpha($name)) {
                $errors['name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            $emailToLower = strtolower($email);
            $email = trim($emailToLower);

            if (strlen($email) < 5) {
                $errors['email'] = 'Количество символов в email должно быть больше 5';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'В email обязательно должны быть символы "@" и "."';
            } else {
                $userDb = $this->userModel->getByEmail($email);

                $user = $this->authService->getCurrentUser();
                if ($userDb->getId() !== $user->getId()) {
                    $errors['email'] = 'Пользователь с таким email уже существует';
                }
            }
        }
        return $errors;
    }

    public function logout()
    {
        $this->authService->logout();

        header("Location: /login");
        exit;
    }
}