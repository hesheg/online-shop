<?php

namespace Controllers;

use DTO\AuthDTO;
use Model\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController extends BaseController
{
    public function getRegistrateForm()
    {
        require_once '../Views/registration_form.php';
    }

    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $password_hash = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            User::create($request->getName(), $request->getEmail(), $password_hash);

            header("Location: /login");
            exit;
        }

        require_once '../Views/registration_form.php';
    }


    public function getLoginForm()
    {
        require_once '../Views/login_form.php';
    }

    public function login(LoginRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $dto = new AuthDTO($request->getEmail(), $request->getPassword());
            $result = $this->authService->auth($dto);


            if ($result === true) {
                header("Location: /profile");
                exit;
            } else {
                $errors['username'] = 'username or password incorrect';
            }
        }
        return require_once '../Views/login_form.php';
    }


    public function profile()
    {
//        throw new \Exception("Test error");
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            $user = User::getById($user->getId());

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

    public function editProfile(EditProfileRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }

        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $user = $this->authService->getCurrentUser();

            $user = User::getById($user->getId());

            if ($name !== $user->getName()) {
                User::updateNameById($name, $user->getId());
            }

            if ($email !== $user->getEmail()) {
                User::updateEmailById($email, $user->getId());
            }

            header("Location: /profile");
            exit;
        }
        require_once '../Views/edit_profile_form.php';
    }

    public function logout()
    {
        $this->authService->logout();

        header("Location: /login");
        exit;
    }
}