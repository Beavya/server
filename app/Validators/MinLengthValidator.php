<?php

namespace Validators;

use Beavya\Validation\AbstractValidator;

class MinLengthValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать минимум :min символов';

    public function rule(): bool
    {
        $min = $this->args[0] ?? 2;
        $this->messageKeys[':min'] = $min;
        return strlen($this->value) >= $min;
    }
}