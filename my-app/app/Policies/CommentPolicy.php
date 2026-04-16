<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Модерация комментариев — только для модераторов
     */
    public function moderate(User $user): Response
    {
        return $user->hasRole('moderator')
            ? Response::allow()
            : Response::deny('Только модераторы могут управлять комментариями.');
    }

    /**
     * Создание комментария — для авторизованных пользователей
     */
    public function create(User $user): bool
    {
        return true; // или $user->hasRole('reader') || $user->hasRole('moderator')
    }

    /**
     * Просмотр комментария — публично, но только одобренные
     */
    public function view(?User $user, Comment $comment): bool
    {
        // Модератор видит всё, остальные — только одобренные
        return $user?->hasRole('moderator') || $comment->is_approved;
    }
}
