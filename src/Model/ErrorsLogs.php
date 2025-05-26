<?php

namespace Model;

class ErrorsLogs extends Model
{
    public static function addError($exception): void
    {
        $stmt = static::getPDO()->prepare(
            "INSERT INTO errors_logs (message, file, line, created_at) 
                VALUES (:message, :file, :line, :created_at)"
        );

        $stmt->execute([
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}