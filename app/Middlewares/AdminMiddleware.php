<?php

namespace Middlewares;

use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        if (app()->auth::user()->id_role != 1) {
            app()->route->redirect('/');
        }

        return $request;
    }
}