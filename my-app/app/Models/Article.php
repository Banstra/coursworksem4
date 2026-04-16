<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_desc',
        'full_text',
        'preview_image',
        'full_image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
    ];

    // 🔗 Отношение: у статьи много комментариев
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // 🔗 Отношение: комментарии, прошедшие модерацию (удобный скоуп)
    public function approvedComments(): HasMany
    {
        return $this->comments()->where('is_approved', true);
    }

    // Автоматическая генерация slug из name (если не передан)
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value, $attrs) => $value ?? \Str::slug($attrs['name']),
        );
    }
}
