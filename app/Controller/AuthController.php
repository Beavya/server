<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\Token;
use Src\Validator\Validator;
// use Beavya\Validation\Validator;

class AuthController
{
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
                app()->route->redirect('/add_librarian');
                return false;
            }

            app()->route->redirect('/books');
            return false;
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        app()->auth::logout();
        app()->route->redirect('/');
    }


    public function generateToken(Request $request): void
    {
        if ($request->method !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        $login = $request->login;
        $password = $request->password;
        
        if (!Auth::attempt(['login' => $login, 'password' => $password])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
            return;
        }
        
        $user = Auth::user();
        
        Token::where('id_staff', $user->id_staff)->delete();
        
        $token = bin2hex(random_bytes(32));
        
        Token::create([
            'id_staff' => $user->id_staff,
            'token' => $token
        ]);
        
        echo json_encode([
            'token' => $token
        ]);
    }
}