@extends('layouts.app')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('articles.index') }}" style="display: inline-block; margin-bottom: 20px; color: #3498db;">← Назад</a>

        <h1>{{ $article->name }}</h1>

        @if($article->full_image)
            <img src="{{ asset('images/' . $article->full_image) }}"
                 alt="{{ $article->name }}"
                 style="width: 100%; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        @endif

        <p style="font-size: 16px; line-height: 1.6;">{!! nl2br(e($article->full_text)) !!}</p>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">

        <!-- Кнопки управления -->
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('articles.edit', $article) }}" style="background: #f39c12; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">️ Редактировать</a>

            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Удалить эту новость?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">🗑️ Удалить</button>
            </form>
        </div>
    </div>
@endsection
