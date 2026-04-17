<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class PriceValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть положительным целым числом';

    public function rule(): bool
    {
        if (!preg_match('/^\d+$/', (string) $this->value)) {
            return false;
        }

        return intval($this->value) > 0;
    }
}