<?php

return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\Staff::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'librarian' => \Middlewares\LibrarianMiddleware::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequiredValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'max' => \Validators\MaxLengthValidator::class,
        'phone' => \Validators\PhoneValidator::class,
        'price' => \Validators\PriceValidator::class,
        'image' => \Validators\ImageValidator::class,
        'future_date' => \Validators\FutureDateValidator::class,
    ],
];