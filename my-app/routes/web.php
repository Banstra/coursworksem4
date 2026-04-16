<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

// Главная + галерея
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');

// Статические страницы
Route::view('/about', 'about')->name('about');

Route::get('/contacts', function () {
    $contacts = [
        ['type' => 'Email',    'value' => 'student@example.com'],
        ['type' => 'Телефон',  'value' => '+7 (999) 123-45-67'],
        ['type' => 'Telegram', 'value' => '@username'],
        ['type' => 'Адрес',    'value' => 'г. Москва, ул. Учебная, д. 10'],
    ];
    return view('contacts', compact('contacts'));
})->name('contacts');

// 🔐 Авторизация / Регистрация
Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('signin.store');
