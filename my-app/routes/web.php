<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
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
