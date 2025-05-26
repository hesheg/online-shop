<?php

namespace Service\Logger;

use Model\ErrorsLogs;
use PDO;

class LoggerDbService implements LoggerInterface
{
    private PDO $pdo;
    private ErrorsLogs $errorsLogs;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
        $this->errorsLogs = new ErrorsLogs();
    }

    public function error($exception): void
    {
        ErrorsLogs::addError($exception);
        require_once '../Views/500.php';
    }
}