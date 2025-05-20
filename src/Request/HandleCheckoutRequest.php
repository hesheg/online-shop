<?php

namespace Request;

class HandleCheckoutRequest
{
    public function __construct(private array $data)
    {
    }

    public function getName()
    {
        return $this->data['contact_name'];
    }

    public function getPhone()
    {
        return $this->data['contact_phone'];
    }

    public function getComment()
    {
        return $this->data['comment'];
    }

    public function getAddress()
    {
        return $this->data['address'];
    }


    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['contact_name'])) {
            $name = $this->data['contact_name'];

            if (strlen($name) < 2 || strlen($name) > 40) {
                $errors['contact_name'] = 'В имени должно быть от 2 до 40 символов';
            } elseif (!ctype_alpha($name)) {
                $errors['contact_name'] = 'В имени не должны быть цифры и другие знаки. Только латинские буквы';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }

        if (isset($this->data['contact_phone'])) {
            $phone = $this->data['contact_phone'];

            if (is_numeric($phone)) {
                if (strlen($phone) < 11) {
                    $errors['contact_phone'] = 'Количество символов в номере должно быть больше 9';
                } elseif (!str_contains($phone, '+7')) {
                    $errors['contact_phone'] = 'Номер должен начинаться на "+7"';
                }
            } else {
                $errors['contact_phone'] = 'Номер должен состоять из цифр';
            }
        }


        if (empty($this->data['address'])) {
            $errors['address'] = 'Введите адрес доставки';
        }
        return $errors;
    }
}