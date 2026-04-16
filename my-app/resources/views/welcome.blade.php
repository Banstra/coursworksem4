@extends('layouts.app')

@section('title', 'Главная - Новости')

@section('content')
    <h1>Последние новости</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
        @foreach($articles as $article)
            <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <a href="{{ route('gallery', $article['full_image']) }}">
                    <img src="{{ asset('images/' . $article['preview_image']) }}"
                         alt="{{ $article['name'] }}"
                         style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                </a>
                <div style="padding: 15px;">
                    <h3 style="margin: 0 0 10px 0; color: #2c3e50;">{{ $article['name'] }}</h3>
                    <p style="color: #7f8c8d; font-size: 14px; margin: 0 0 10px 0;">
                        📅 {{ $article['date'] }}
                    </p>
                    <p style="margin: 0; color: #555;">
                        {{ Str::limit($article['shortDesc'] ?? $article['desc'], 100) }}
                    </p>
                    <a href="{{ route('gallery', $article['full_image']) }}"
                       style="display: inline-block; margin-top: 10px; color: #3498db; text-decoration: none; font-weight: 500;">
                        Подробнее →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
