@extends('layouts.app')

@section('title', 'Список новостей')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Новости</h1>
        <a href="{{ route('articles.create') }}" style="background: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Добавить новость</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @foreach($articles as $article)
            <article style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;">
                <a href="{{ route('articles.show', $article) }}">
                    <img src="{{ asset('images/' . $article->preview_image) }}"
                         alt="{{ $article->name }}"
                         style="width: 100%; height: 180px; object-fit: cover;">
                </a>
                <div style="padding: 15px;">
                    <h3 style="margin: 0 0 10px;"><a href="{{ route('articles.show', $article) }}" style="color: inherit; text-decoration: none;">{{ $article->name }}</a></h3>
                    <p style="font-size: 14px; color: #777;">{{ \Str::limit($article->short_desc, 80) }}</p>
                </div>
            </article>
        @endforeach
    </div>

    <div style="margin-top: 10px;">
        {{ $articles->links() }}
    </div>
@endsection
