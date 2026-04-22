<?php

namespace Controller;

use Src\View;
use Src\Request;
// use Src\Validator\Validator;
use Beavya\Validation\Validator;
use Model\Staff;

class LibrarianController
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
                'phone_number' => ['required', 'min:16'],
            ], [
                'required' => 'Поле :field пусто',
                'unique'   => 'Поле :field должно быть уникально',
                'max'      => 'Поле :field должно содержать максимум :max символов',
                'min'      => 'Поле :field должно содержать минимум :min символов'
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
}