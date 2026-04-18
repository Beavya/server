<?php

namespace Middlewares;

use Src\Request;
use function Collect\collection;

class SpecialCharsMiddleware
{
    public function handle(Request $request): Request
    {
        collection($request->all())->each(function ($value, $key, $request) {
            if (is_string($value)) {
                $request->set($key, htmlspecialchars($value));
            }
        }, $request);

        return $request;
    }
}