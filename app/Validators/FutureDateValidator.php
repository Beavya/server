<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class FutureDateValidator extends AbstractValidator
{
    protected string $message = 'Дата возврата должна быть в будущем';

    public function rule(): bool
    {
        $today = date('Y-m-d');

        return $this->value > $today;
    }
}
