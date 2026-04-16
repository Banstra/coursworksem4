<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Форма регистрации
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Регистрация нового пользователя
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Введите имя',
            'name.min' => 'Имя должно быть не короче 2 символов',
            'email.required' => 'Укажите email',
            'email.unique' => 'Пользователь с таким email уже существует',
            'password.required' => 'Введите пароль',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 🔐 Генерируем токен Sanctum (опционально для веб, но требуем по заданию)
        $token = $user->createToken('web-token')->plainTextToken;

        // Сохраняем токен в сессию для последующих запросов (опционально)
        // $request->session()->put('sanctum_token', $token);

        return redirect()->route('login')
            ->with('success', 'Регистрация успешна! Теперь войдите в систему.');
    }

    /**
     * Форма входа
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Аутентификация пользователя
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Стандартная аутентификация через сессии (для веба)
        if (!Auth::attempt($validated)) {
            return back()->withErrors([
                'email' => 'Неверный email или пароль',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // 🔐 Создаём токен Sanctum для API-доступа
        $user = Auth::user();
        $token = $user->createToken('web-token')->plainTextToken;

        // Опционально: сохраняем токен в кук/сессию для фронтенда
        // cookie('sanctum_token', $token, 60*24);

        return redirect()->route('home')
            ->with('success', 'Добро пожаловать, ' . $user->name . '!');
    }

    /**
     * Выход из системы
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        // 🔐 Удаляем все токены Sanctum пользователя
        if ($user) {
            $user->tokens()->delete();
        }

        // Завершаем сессию
        Auth::logout();

        // Инвалидируем сессию и регенерируем CSRF-токен
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Вы вышли из системы');
    }
}
