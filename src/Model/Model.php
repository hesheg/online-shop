<?php

namespace Model;

use PDO;

abstract class Model
{
    protected static PDO $PDO;

    public static function getPDO(): PDO
    {
        static::$PDO = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");

        return static::$PDO;
    }

    public static function echoPre($value)
    {
        echo "<pre>";
        print_r($value);
        die;
    }
}