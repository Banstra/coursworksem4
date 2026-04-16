<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Просмотр списка/одной статьи — разрешён всем
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Создание — только модератор
     */
    public function create(User $user): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Только модераторы могут создавать новости.');
    }

    /**
     * Редактирование — только модератор
     */
    public function update(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Редактирование доступно только модераторам.');
    }

    /**
     * Удаление — только модератор
     */
    public function delete(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Удаление новостей доступно только модераторам.');
    }

    /**
     * Восстановление (если есть soft deletes)
     */
    public function restore(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Восстановление доступно только модераторам.');
    }

    /**
     * Принудительное удаление
     */
    public function forceDelete(User $user, Article $article): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Полное удаление доступно только модераторам.');
    }
}
