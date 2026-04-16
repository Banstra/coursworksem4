<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Эндпоинт для получения данных текущего пользователя через Sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
