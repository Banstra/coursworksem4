<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.signin');
    }

    public function registration(Request $request)
    {
        // 1. Валидация
        $validated = $request->validate([
            'name'     => 'required|string|min:2|max:50',
            'email'    => 'required|email|unique:users,email|max:100',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Поле «Имя» обязательно',
            'email.required'     => 'Укажите email',
            'email.email'        => 'Введите корректный email',
            'email.unique'       => 'Такой email уже зарегистрирован',
            'password.required'  => 'Пароль обязателен',
            'password.min'       => 'Минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        // 2. Сохранение в БД
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // ️ Обязательно хешируем!
        ]);

        Log::info('User registered', ['id' => $user->id, 'email' => $user->email]);

        // 3. JSON-ответ по заданию
        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно зарегистрирован',
            'data'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'created_at' => $user->created_at->format('d.m.Y H:i:s'),
            ]
        ], 201);
    }
}
