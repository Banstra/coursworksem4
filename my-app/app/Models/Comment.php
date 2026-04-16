<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'content',
        'is_approved',
        'moderated_at',
        'moderated_by',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    // Отношения
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    // Scope: только одобренные комментарии
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope: только на модерации
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
