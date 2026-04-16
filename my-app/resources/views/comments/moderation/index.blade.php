@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="color: #2c3e50; margin-bottom: 20px;">🔍 Комментарии на модерации</h1>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @forelse($pendingComments as $comment)
            <article style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 15px; background: #fff;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <strong>{{ $comment->user->name }}</strong>
                    <small style="color: #777;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </div>

                <p style="margin: 10px 0; color: #555;">{{ $comment->content }}</p>

                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                    <small style="color: #3498db;">
                        📰 Статья: <a href="{{ route('articles.show', $comment->article) }}">{{ $comment->article->name }}</a>
                    </small>
                </div>

                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <form action="{{ route('comments.moderation.approve', $comment) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" style="background: #27ae60; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                            ✅ Принять
                        </button>
                    </form>

                    <form action="{{ route('comments.moderation.reject', $comment) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                            ❌ Отклонить
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <p style="color: #777; text-align: center; padding: 30px;">
                🎉 Нет комментариев, ожидающих модерации
            </p>
        @endforelse

        <div style="margin-top: 20px;">
            {{ $pendingComments->links() }}
        </div>
    </div>
@endsection
