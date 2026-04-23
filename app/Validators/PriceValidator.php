<?php

namespace Validators;

// use Beavya\Validation\AbstractValidator;
use Src\Validator\AbstractValidator;

class PriceValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть положительным целым числом';

    public function rule(): bool
    {
        return is_numeric($this->value) && intval($this->value) > 0;
    }
}