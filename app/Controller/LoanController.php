<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Validator\Validator;
use Model\Reader;
use Model\Book;
use Model\Loan;

class LoanController
{
    public function addLoan(Request $request): string
    {
        $readers = Reader::all();
        $books   = Book::where('id_status_book', 1)->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'card_number' => ['required'],
                'id_book'     => ['required'],
                'return_date' => ['required', 'future_date'],
            ], [
                'required'    => 'Поле :field пусто',
                'future_date' => 'Дата возврата должна быть в будущем',
            ]);

            if ($validator->fails()) {
                return new View('site.add_loan', [
                    'error'   => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'readers' => $readers,
                    'books'   => $books
                ]);
            }

            $data = $request->all();
            $data['loan_date'] = date('Y-m-d');
            $data['id_status_loan'] = 1;

            if (Loan::create($data)) {
                $book = Book::find($data['id_book']);
                $book->id_status_book = 2;
                $book->save();
                app()->route->redirect('/books');
            }
        }
        return new View('site.add_loan', ['readers' => $readers, 'books' => $books]);
    }

    public function returnLoan($id_loan, Request $request): string
    {
        $loan = Loan::with('book', 'reader')->find($id_loan);

        if (!$loan || $loan->id_status_loan != 1) {
            $_SESSION['error'] = 'Книга уже возвращена или не найдена';
            app()->route->redirect('/readers/' . $loan->card_number);
            return '';
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'actual_return_date' => ['required', 'after_date:' . $loan->loan_date],
            ], [
                'required'    => 'Укажите дату возврата',
                'after_date'  => 'Дата возврата не может быть раньше даты выдачи',
            ]);

            if ($validator->fails()) {
                return (new View('site.return_loan', [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'loan'  => $loan
                ]))->__toString();
            }

            $loan->actual_return_date = $request->actual_return_date;
            $loan->id_status_loan = 2;
            $loan->save();

            $book = Book::find($loan->id_book);
            $book->id_status_book = 1;
            $book->save();

            $_SESSION['success'] = 'Книга успешно возвращена';
            app()->route->redirect('/readers/' . $loan->card_number);
            return '';
        }

        return (new View('site.return_loan', ['loan' => $loan]))->__toString();
    }
}