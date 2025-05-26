<?php

namespace Service;

class BaseService
{
    public function echoPre($value)
    {
        echo "<pre>";
        print_r($value);
        die;
    }
}