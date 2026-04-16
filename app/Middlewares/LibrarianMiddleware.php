<?php

namespace Middlewares;

use Src\Request;

class LibrarianMiddleware
{
    public function handle(Request $request)
    {
        if (app()->auth::user()->id_role != 2) {
            app()->route->redirect('/hello');
        }
        return $request;
    }
}