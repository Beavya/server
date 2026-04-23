<?php

namespace Validators;

// use Beavya\Validation\AbstractValidator;
use Src\Validator\AbstractValidator;

class RequiredValidator extends AbstractValidator
{
    protected string $message = 'Поле :field пусто';

    public function rule(): bool
    {
        return !empty($this->value);
    }
}