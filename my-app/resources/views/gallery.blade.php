@extends('layouts.app')

@section('title', 'Галерея - ' . ($article['name'] ?? 'Просмотр'))

@section('content')
    @if($article)
        <div style="max-width: 800px; margin: 0 auto;">
            <a href="{{ route('home') }}" style="color: #3498db; text-decoration: none; display: inline-block; margin-bottom: 20px;">
                ← Назад к новостям
            </a>

            <h1 style="color: #2c3e50; margin-bottom: 20px;">{{ $article['name'] }}</h1>

            <div style="margin-bottom: 20px;">
                <img src="{{ asset('images/' . $article['full_image']) }}"
                     alt="{{ $article['name'] }}"
                     style="width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            </div>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <p style="color: #7f8c8d; margin-bottom: 15px;">
                    <strong>Дата публикации:</strong> {{ $article['date'] }}
                </p>
                <div style="color: #555; line-height: 1.6;">
                    {!! nl2br(e($article['desc'])) !!}
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 40px;">
            <h2 style="color: #e74c3c;">Изображение не найдено</h2>
            <a href="{{ route('home') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 4px;">
                Вернуться на главную
            </a>
        </div>
    @endif
@endsection
