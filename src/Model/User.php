<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public static function createObj(array|false $user): self|null
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

    public static function getByEmail(string $email): self|null
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return static::createObj($user);
    }

    public static function getById(int $userId): self|null
    {
        $stmt = static::getPDO()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();

        return static::createObj($user);
    }

    public static function create(string $name, string $email, string $password)
    {
        $stmt = static::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function updateNameById(string $name, int $userId)
    {
        $stmt = static::getPDO()->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute(['name' => $name]);
    }

    public static function updateEmailById(string $email, int $userId)
    {
        $stmt = static::getPDO()->prepare("UPDATE users SET email = :email WHERE id = $userId");
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