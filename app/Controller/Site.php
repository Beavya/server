<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\Staff;
use Src\Auth\Auth;
use Src\Validator\Validator;
use Model\Reader;

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

    public function logout(): void
    {
        app()->auth::logout();
        app()->route->redirect('/hello');
    }
}