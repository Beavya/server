<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;
use Model\Staff;
use Model\Reader;
use Model\Book;
use Model\Author;
use Model\Loan;

class Site
{
    public function addLibrarian(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login'        => ['required', 'unique:staff,login', 'max:255'],
                'password'     => ['required'],
                'first_name'   => ['required', 'max:255'],
                'last_name'    => ['required', 'max:255'],
                'middle_name'  => ['max:100'],
                'address'      => ['required', 'max:255'],
                'phone_number' => ['required', 'phone'],
            ], [
                'required' => 'Поле :field пусто',
                'unique'   => 'Поле :field должно быть уникально',
                'max'      => 'Поле :field должно содержать максимум :max символов',
                'phone'    => 'Неверный формат телефона',
            ]);

            if ($validator->fails()) {
                return new View('site.add_librarian', [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            if (Staff::create($request->all())) {
                return new View('site.add_librarian', [
                    'success' => 'Библиотекарь успешно добавлен'
                ]);
            }
        }
        return new View('site.add_librarian');
    }

    public function addReader(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name'    => ['required', 'max:255'],
                'first_name'   => ['required', 'max:255'],
                'middle_name'  => ['max:255'],
                'address'      => ['required', 'max:255'],
                'phone_number' => ['required', 'phone'],
            ], [
                'required' => 'Поле :field пусто',
                'max'      => 'Поле :field должно содержать максимум :max символов',
                'phone'    => 'Неверный формат телефона',
            ]);

            if ($validator->fails()) {
                return new View('site.add_reader', [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            if (Reader::create($request->all())) {
                return new View('site.add_reader', [
                    'success' => 'Читатель успешно добавлен'
                ]);
            }
        }
        return new View('site.add_reader');
    }

    public function addBook(Request $request): string
    {
        $authors = Author::all();

        if ($request->method === 'POST') {
            if (!isset($_FILES['cover']) || $_FILES['cover']['error'] === UPLOAD_ERR_NO_FILE) {
                return new View('site.add_book', [
                    'error'   => 'Выберите файл обложки',
                    'authors' => $authors
                ]);
            }

            $validator = new Validator($request->all(), [
                'title'            => ['required', 'max:255'],
                'id_author'        => ['required'],
                'publication_year' => ['required', 'max:4'],
                'price'            => ['required', 'price', 'max:10'],
                'summary'          => ['max:255'],
                'is_new'           => [],
            ], [
                'required' => 'Поле :field пусто',
                'max'      => 'Поле :field должно содержать максимум :max символов',
                'price'    => 'Поле :field должно быть положительным целым числом',
            ]);

            $fileValidator = new Validator(['cover' => $_FILES['cover']], [
                'cover' => ['required', 'image'],
            ], [
                'required' => 'Загрузите обложку книги',
                'image'    => 'Обложка должна быть изображением (jpg, png, gif)',
            ]);

            if ($validator->fails() || $fileValidator->fails()) {
                $errors = array_merge($validator->errors(), $fileValidator->errors());
                return new View('site.add_book', [
                    'error'   => json_encode($errors, JSON_UNESCAPED_UNICODE),
                    'authors' => $authors
                ]);
            }

            $data = $request->all();
            $data['id_status_book'] = 1;
            $data['is_new'] = $data['is_new'] ?? 0;

            $filename = time() . '_' . $_FILES['cover']['name'];
            move_uploaded_file($_FILES['cover']['tmp_name'], __DIR__ . '/../../public/uploads/' . $filename);
            $data['cover'] = '/server/uploads/' . $filename;

            if (Book::create($data)) {
                return new View('site.add_book', [
                    'success' => 'Книга успешно добавлена',
                    'authors' => $authors
                ]);
            }
        }
        return new View('site.add_book', ['authors' => $authors]);
    }

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

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $validator = new Validator($request->all(), [
            'login'    => ['required'],
            'password' => ['required'],
        ], [
            'required' => 'Поле :field пусто',
        ]);

        if ($validator->fails()) {
            return new View('site.login', [
                'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
            ]);
        }

        if (Auth::attempt($request->all())) {
            if (app()->auth::user()->id_role == 1) {
                header('Location: /server/add_librarian');
                exit;
            }

            header('Location: /server/books');
            exit;
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        app()->auth::logout();
        app()->route->redirect('/login');
    }

    public function readers(Request $request): string
    {
        $search = $request->get('search') ?? '';

        if ($search) {
            $readers = Reader::where('last_name', 'like', "%$search%")
                ->orWhere('first_name', 'like', "%$search%")
                ->orWhere('middle_name', 'like', "%$search%")
                ->get();
        } else {
            $readers = Reader::all();
        }
        return new View('site.readers', ['readers' => $readers, 'search' => $search]);
    }

    public function books(Request $request): string
    {
        $search = $request->get('search') ?? '';
        $query = Book::withCount('loans');

        if (!empty($search)) {
            $query->where('title', 'like', "%$search%");
        }

        $books = $query->orderBy('loans_count', 'DESC')->get();

        foreach ($books as $book) {
            $book->total_loans = $book->loans_count;
        }

        return (new View('site.books', ['books' => $books, 'search' => $search]))->__toString();
    }

    public function readerProfile($cardNumber, Request $request): string
    {
        $reader = Reader::find($cardNumber);
        if (!$reader) {
            app()->route->redirect('/readers');
        }

        $loans = Loan::where('card_number', $cardNumber)->with('book')->get();
        return new View('site.reader_profile', ['reader' => $reader, 'loans' => $loans]);
    }

    public function bookProfile($id_book, Request $request): string
    {
        $book = Book::with('author')->find($id_book);
        if (!$book) {
            app()->route->redirect('/books');
        }

        $loans = Loan::where('id_book', $id_book)
            ->with('reader')
            ->orderBy('loan_date', 'DESC')
            ->get();

        return (new View('site.book_profile', ['book' => $book, 'loans' => $loans]))->__toString();
    }

    public function popularBooks(Request $request): string
    {
        $books = Book::withCount('loans')
            ->orderBy('loans_count', 'DESC')
            ->get();

        foreach ($books as $book) {
            $book->total_loans = $book->loans_count;
        }

        return (new View('site.books', [
            'books'  => $books,
            'search' => '',
            'sort'   => 'popular'
        ]))->__toString();
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