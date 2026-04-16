<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;

// 🔐 Защищённые маршруты (только для авторизованных)
Route::middleware(['auth:sanctum'])->group(function () {
    // CRUD для статей (доступен только авторизованным)
    Route::resource('articles', ArticleController::class);

    // Профиль пользователя
    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile');
});

// 🌐 Публичные маршруты
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');
Route::view('/about', 'about')->name('about');

Route::get('/contacts', function () {
    $contacts = [
        ['type' => 'Email', 'value' => 'student@example.com'],
        ['type' => 'Телефон', 'value' => '+7 (999) 123-45-67'],
    ];
    return view('contacts', compact('contacts'));
})->name('contacts');

// 🔐 Авторизация / Регистрация
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['web'])->post('/logout', [AuthController::class, 'logout'])->name('logout');
