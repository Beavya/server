<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Validator\Validator;
use Model\Book;
use Model\Author;
use Model\Loan;

class BookController
{
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
}