<?php

require_once '../Model/Model.php';
class User extends Model
{
    public function getByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();

        return $result;
    }

    public function registrate(string $name, string $email, string $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getById(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $result = $stmt->fetch();

        return $result;
    }

    public function updateNameById(string $name, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute(['name' => $name]);
    }

    public function updateEmailById(string $email, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET email = :email WHERE id = $userId");
        $stmt->execute(['email' => $email]);
    }
}