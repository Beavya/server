<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть изображением (jpg, png, gif)';

    public function rule(): bool
    {
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];

        return in_array($this->value['type'], $allowed);
    }
}