<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Validator\Validator;
use Model\Reader;
use Model\Loan;

class ReaderController
{
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

    public function readerProfile($cardNumber, Request $request): string
    {
        $reader = Reader::find($cardNumber);
        if (!$reader) {
            app()->route->redirect('/readers');
        }

        $loans = Loan::where('card_number', $cardNumber)->with('book')->get();
        return new View('site.reader_profile', ['reader' => $reader, 'loans' => $loans]);
    }
}