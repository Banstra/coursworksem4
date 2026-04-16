<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    $contacts = [
        ['type' => 'Email',    'value' => 'student@example.com'],
        ['type' => 'Телефон',  'value' => '+7 (999) 123-45-67'],
        ['type' => 'Telegram', 'value' => '@username'],
        ['type' => 'Адрес',    'value' => 'г. Москва, ул. Учебная, д. 10'],
    ];

    return view('contacts', compact('contacts'));
})->name('contacts');

Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');
