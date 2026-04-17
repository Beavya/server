<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class PhoneValidator extends AbstractValidator
{
    protected string $message = 'Неверный формат телефона';

    public function rule(): bool
    {
        $phone = preg_replace('/[^0-9]/', '', $this->value);

        return preg_match('/^(7|8)[0-9]{10}$/', $phone);
    }
}