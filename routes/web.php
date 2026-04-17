<?php

use Src\Route;

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/add_librarian', [Controller\Site::class, 'addLibrarian'])
    ->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/readers/add', [Controller\Site::class, 'addReader'])
    ->middleware('auth', 'librarian');

Route::add(['GET', 'POST'], '/books/add', [Controller\Site::class, 'addBook'])
    ->middleware('auth', 'librarian');

Route::add(['GET', 'POST'], '/loans/add', [Controller\Site::class, 'addLoan'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/readers', [Controller\Site::class, 'readers'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/readers/{card_number}', [Controller\Site::class, 'readerProfile'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/books', [Controller\Site::class, 'books'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/books/popular', [Controller\Site::class, 'popularBooks'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/books/{id_book}', [Controller\Site::class, 'bookProfile'])
    ->middleware('auth', 'librarian');

Route::add(['GET', 'POST'], '/loans/return/{id_loan}', [Controller\Site::class, 'returnLoan'])
    ->middleware('auth', 'librarian');