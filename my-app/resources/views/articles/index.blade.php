@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <h1 style="color: #2c3e50; margin-bottom: 20px;">📰 Последние новости</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @forelse($articles as $article)
            <article style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <a href="{{ route('articles.show', $article) }}">
                    <img src="{{ asset('images/' . $article->preview_image) }}"
                         alt="{{ $article->name }}"
                         style="width: 100%; height: 180px; object-fit: cover;">
                </a>
                <div style="padding: 15px;">
                    <time style="color: #7f8c8d; font-size: 13px;">{{ $article->published_at->format('d.m.Y') }}</time>
                    <h3 style="margin: 8px 0; color: #2c3e50;">
                        <a href="{{ route('articles.show', $article) }}" style="color: inherit; text-decoration: none;">
                            {{ $article->name }}
                        </a>
                    </h3>
                    <p style="color: #555; font-size: 14px; margin: 0;">
                        {{ Str::limit($article->short_desc, 100) }}
                    </p>
                    <a href="{{ route('articles.show', $article) }}"
                       style="display: inline-block; margin-top: 10px; color: #3498db; text-decoration: none; font-weight: 500;">
                        Читать далее →
                    </a>
                </div>
            </article>
        @empty
            <p style="grid-column: 1/-1; text-align: center; color: #7f8c8d;">
                Новостей пока нет. Запустите <code>php artisan db:seed</code> для наполнения.
            </p>
        @endforelse
    </div>

    {{-- Пагинация --}}
    <div style="margin-top: 30px;">
        {{ $articles->links() }}
    </div>
@endsection
