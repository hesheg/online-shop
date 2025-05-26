<?php

namespace Service\Logger;

class LoggerFileService implements LoggerInterface
{
    public function error($exception): void
    {
        $file = '../Storage/Log/errors.txt';

        $log = "--------------------------" . PHP_EOL;
        $log .= "Date: " . date('d-m-Y H:i:s') . PHP_EOL;
        $log .= "Message: " . $exception->getMessage() . PHP_EOL;
        $log .= "File: " . $exception->getFile() . PHP_EOL;
        $log .= "Line: " . $exception->getLine() . PHP_EOL;
        $log .= "--------------------------" . PHP_EOL . PHP_EOL;

        if (!file_exists($file)) {
            file_put_contents($file, '');
        }

        if (is_writable($file)) {
            file_put_contents($file, $log, FILE_APPEND);
        } else {
            echo 'Нет доступа для записи в файл';
        }

        require_once '../Views/500.php';
    }
}