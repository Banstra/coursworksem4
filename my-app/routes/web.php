<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

// 📰 Новости (ресурсный контроллер, но только index и show)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Остальные маршруты...
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');
Route::view('/about', 'about')->name('about');
Route::get('/contacts', fn() => view('contacts', [
    'contacts' => [
        ['type' => 'Email', 'value' => 'student@example.com'],
        ['type' => 'Телефон', 'value' => '+7 (999) 123-45-67'],
        ['type' => 'Telegram', 'value' => '@username'],
        ['type' => 'Адрес', 'value' => 'г. Москва, ул. Учебная, д. 10'],
    ]
]))->name('contacts');
Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('signin.store');
