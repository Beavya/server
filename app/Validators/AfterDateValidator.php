<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class AfterDateValidator extends AbstractValidator
{
    protected string $message = 'Дата возврата не может быть раньше даты выдачи';

    public function rule(): bool
    {
        $loanDate = $this->args[0] ?? null;

        return $this->value >= $loanDate;
    }
}