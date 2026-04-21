<?php

use Src\Route;

Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);

Route::add(['GET', 'POST'], '/add_librarian', [Controller\LibrarianController::class, 'addLibrarian'])
    ->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/readers/add', [Controller\ReaderController::class, 'addReader'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/readers', [Controller\ReaderController::class, 'readers'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/readers/{card_number}', [Controller\ReaderController::class, 'readerProfile'])
    ->middleware('auth', 'librarian');

Route::add(['GET', 'POST'], '/books/add', [Controller\BookController::class, 'addBook'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/books/popular', [Controller\BookController::class, 'popularBooks'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/books', [Controller\BookController::class, 'books'])
    ->middleware('auth', 'librarian');

Route::add('GET', '/books/{id_book}', [Controller\BookController::class, 'bookProfile'])
    ->middleware('auth', 'librarian');

Route::add(['GET', 'POST'], '/loans/add', [Controller\LoanController::class, 'addLoan'])
    ->middleware('auth', 'librarian');
Route::add(['GET', 'POST'], '/loans/return/{id_loan}', [Controller\LoanController::class, 'returnLoan'])
    ->middleware('auth', 'librarian');