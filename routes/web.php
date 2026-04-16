<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/add_librarian', [Controller\Site::class, 'addLibrarian'])
    ->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/readers/add', [Controller\Site::class, 'addReader'])
    ->middleware('auth', 'librarian');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
