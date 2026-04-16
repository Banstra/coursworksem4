<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Article extends Model
{
    use HasFactory;

    // Разрешаем массовое назначение для этих полей
    protected $fillable = [
        'name',
        'slug',
        'short_desc',
        'full_text',
        'preview_image',
        'full_image',
        'published_at',
    ];

    // Автоматическое приведение дат
    protected $casts = [
        'published_at' => 'date:Y-m-d',
    ];

    // Автоматическая генерация slug из name (если не передан)
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value, $attrs) => $value ?? \Str::slug($attrs['name']),
        );
    }
}
