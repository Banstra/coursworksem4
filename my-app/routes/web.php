<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

//  CRUD для новостей
Route::resource('articles', ArticleController::class);

// Остальные маршруты
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');
Route::view('/about', 'about')->name('about');
Route::get('/contacts', fn() => view('contacts', [
    'contacts' => [
        ['type' => 'Email', 'value' => 'student@example.com'],
        ['type' => 'Телефон', 'value' => '+7 (999) 123-45-67'],
    ]
]))->name('contacts');
Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('signin.store');
