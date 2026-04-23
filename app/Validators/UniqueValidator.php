<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
// use Beavya\Validation\AbstractValidator;
use Src\Validator\AbstractValidator;

class UniqueValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть уникально';

    public function rule(): bool
    {
        return (bool) !Capsule::table($this->args[0])
            ->where($this->args[1], $this->value)
            ->count();
    }
}


