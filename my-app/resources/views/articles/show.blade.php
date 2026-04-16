@extends('layouts.app')

@section('title', $article->name)

@section('content')
    <article style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('articles.index') }}" style="color: #3498db; text-decoration: none; display: inline-block; margin-bottom: 20px;">
            ← Назад к списку
        </a>

        <h1 style="color: #2c3e50; margin-bottom: 10px;">{{ $article->name }}</h1>
        <time style="color: #7f8c8d; display: block; margin-bottom: 20px;">
            Опубликовано: {{ $article->published_at->format('d.m.Y H:i') }}
        </time>

        @if($article->full_image)
            <img src="{{ asset('images/' . $article->full_image) }}"
                 alt="{{ $article->name }}"
                 style="width: 100%; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        @endif

        <div style="color: #555; line-height: 1.7; font-size: 16px;">
            {!! nl2br(e($article->full_text)) !!}
        </div>
    </article>
@endsection
