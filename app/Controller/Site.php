<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\Staff;
use Src\Auth\Auth;
use Src\Validator\Validator;
use Model\Reader;
use Model\Book;
use Model\Author;
use Model\Loan;

class Site
{

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function addLibrarian(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'unique:staff,login', 'max:255'],
                'password' => ['required'],
                'first_name' => ['required', 'max:255'],
                'last_name' => ['required', 'max:255'],
                'middle_name' => ['max:100'],
                'address' => ['required', 'max:255'],
                'phone_number' => ['required', 'phone'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'max' => 'Поле :field должно содержать максимум :max символов',
                'phone' => 'Неверный формат телефона',
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
                'last_name' => ['required', 'max:255'],
                'first_name' => ['required', 'max:255'],
                'middle_name' => ['max:255'],
                'address' => ['required', 'max:255'],
                'phone_number' => ['required', 'phone'],
            ], [
                'required' => 'Поле :field пусто',
                'max' => 'Поле :field должно содержать максимум :max символов',
                'phone' => 'Неверный формат телефона',
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
                'error' => 'Выберите файл обложки',
                'authors' => $authors
            ]);
        }

        $validator = new Validator($request->all(), [
            'title' => ['required', 'max:255'],
            'id_author' => ['required'],
            'publication_year' => ['required', 'max:4'],
            'price' => ['required', 'price', 'max:10'],
            'summary' => ['max:255'],
            'is_new' => [],
        ], [
            'required' => 'Поле :field пусто',
            'max' => 'Поле :field должно содержать максимум :max символов',
            'price' => 'Поле :field должно быть положительным целым числом',
        ]);
        
        $fileValidator = new Validator(['cover' => $_FILES['cover']], [
            'cover' => ['required', 'image'],
        ], [
            'required' => 'Загрузите обложку книги',
            'image' => 'Обложка должна быть изображением (jpg, png, gif)',
        ]);
        
        if ($validator->fails() || $fileValidator->fails()) {
            $errors = array_merge($validator->errors(), $fileValidator->errors());
            return new View('site.add_book', [
                'error' => json_encode($errors, JSON_UNESCAPED_UNICODE),
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
        $books = Book::where('id_status_book', 1)->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'card_number' => ['required'],
                'id_book' => ['required'],
                'return_date' => ['required', 'future_date'],
            ], [
                'required' => 'Поле :field пусто',
                'future_date' => 'Дата возврата должна быть в будущем',
            ]);
            
            if ($validator->fails()) {
                return new View('site.add_loan', [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'readers' => $readers,
                    'books' => $books
                ]);
            }

            $data = $request->all();
            $data['loan_date'] = date('Y-m-d');
            $data['id_status_loan'] = 1;

            if (Loan::create($data)) {
                $book = Book::find($data['id_book']);
                $book->id_status_book = 2;
                $book->save();

                return new View('site.add_loan', [
                    'success' => 'Книга успешно выдана',
                    'readers' => $readers,
                    'books' => $books
                ]);
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
            'login' => ['required'],
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
            header('Location: /server/hello');
            exit;
        }
        
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        app()->auth::logout();
        app()->route->redirect('/hello');
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
}

