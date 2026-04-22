<?php

return [
    'auth' => \Src\Auth\Auth::class,

    'identity' => \Model\Staff::class,

    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route'  => \Providers\RouteProvider::class,
        'db'     => \Providers\DBProvider::class,
        'auth'   => \Providers\AuthProvider::class,
    ],

    'routeMiddleware' => [
        'auth'      => \Middlewares\AuthMiddleware::class,
        'admin'     => \Middlewares\AdminMiddleware::class,
        'librarian' => \Middlewares\LibrarianMiddleware::class,
    ],

    'routeAppMiddleware' => [
        'csrf'         => \Middlewares\CSRFMiddleware::class,
        'trim'         => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'json'         => \Middlewares\JSONMiddleware::class,
        'bearer'    => \Middlewares\BearerAuthMiddleware::class,
    ],

    'validators' => [
        'required'    => \Validators\RequiredValidator::class,
        'unique'      => \Validators\UniqueValidator::class,
        'min'         => \Validators\MinLengthValidator::class,
        'max'         => \Validators\MaxLengthValidator::class,
        'price'       => \Validators\PriceValidator::class,
        'image'       => \Validators\ImageValidator::class,
        'future_date' => \Validators\FutureDateValidator::class,
        'after_date'  => \Validators\AfterDateValidator::class,
    ],
];