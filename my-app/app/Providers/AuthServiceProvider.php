<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => \App\Policies\ArticlePolicy::class,
    ];

    public function boot(): void
    {
        // 🔥 Хук before() — выполняется ПЕРЕД всеми проверками
        Gate::before(function (User $user, string $ability) {
            // Если пользователь — модератор, разрешаем ВСЁ
            if ($user->hasRole('moderator')) {
                // Возвращаем кастомный ответ с сообщением
                return $this->allowAsModerator($ability);
            }
            // Для остальных — продолжаем стандартную проверку
            return null;
        });

        // Дополнительные шлюзы (если нужны)
        Gate::define('view-articles', fn(User $user) => true); // все могут смотреть
        Gate::define('create-comment', fn(User $user) => $user->hasRole('reader') || $user->hasRole('moderator'));
    }

    /**
     * Кастомный ответ для модератора
     */
    private function allowAsModerator(string $ability)
    {
        return Gate::allowIf(
            fn() => true,
            "Доступ разрешён: вы модератор (действие: {$ability})"
        );
    }
}
