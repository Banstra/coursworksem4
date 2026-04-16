<?php

use App\Http\Controllers\CommentModerationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request; // ← Убедитесь, что импорт есть в начале файла
use App\Models\Article;

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

// 🔐 Модерация комментариев (только для модераторов)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/comments/moderation', [CommentModerationController::class, 'index'])
        ->name('comments.moderation.index');

    Route::patch('/comments/{comment}/approve', [CommentModerationController::class, 'approve'])
        ->name('comments.moderation.approve');

    Route::patch('/comments/{comment}/reject', [CommentModerationController::class, 'reject'])
        ->name('comments.moderation.reject');
});

Route::post('/articles/{article}/comments', function (Request $request, Article $article) {
    // ✅ Вызываем validate() у экземпляра $request
    $validated = $request->validate([
        'content' => 'required|string|min:3|max:1000',
    ], [
        'content.required' => 'Введите текст комментария',
        'content.min' => 'Комментарий должен содержать не менее 3 символов',
        'content.max' => 'Комментарий не должен превышать 1000 символов',
    ]);

    $comment = $article->comments()->create([
        'user_id' => Auth::id(),
        'content' => $validated['content'],
        'is_approved' => false, // 🔴 По умолчанию — на модерации
    ]);

    return redirect()->back()->with('pending', '🕐 Ваш комментарий отправлен на модерацию.');
})->middleware('auth:sanctum')->name('comments.store');

Route::get('/test-log', function () {
    \Log::debug('🧪 Тестовая запись в лог');
    \Log::info('Пользователь зашёл на /test-log');
    return 'Проверьте storage/logs/laravel.log';
});
