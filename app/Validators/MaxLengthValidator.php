<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MaxLengthValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать максимум :max символов';

    public function rule(): bool
    {
        $max = $this->args[0] ?? 255;
        $this->messageKeys[':max'] = $max;

        return strlen($this->value) <= $max;
    }
}