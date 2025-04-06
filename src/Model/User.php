<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;



    protected function getTableName(): string
    {
        return 'users';
    }

    private function createObj(array|false $user): self|null
    {
        if (!$user) {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $this->createObj($user);
    }

    public function getById(int $userId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();

        return $this->createObj($user);
    }

    public function create(string $name, string $email, string $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function updateNameById(string $name, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET name = :name WHERE id = $userId");
        $stmt->execute(['name' => $name]);
    }

    public function updateEmailById(string $email, int $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET email = :email WHERE id = $userId");
        $stmt->execute(['email' => $email]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}