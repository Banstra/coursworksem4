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
        @can('update', $article)
            <a href="{{ route('articles.edit', $article) }}" class="btn-edit">✏️ Редактировать</a>
        @endcan

        @can('delete', $article)
            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Удалить?');" style="display: inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">🗑️ Удалить</button>
            </form>
        @endcan

        {{-- 💬 Форма добавления комментария --}}
        @auth
            @if(session('pending'))
                <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 4px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
                    {{ session('pending') }}
                </div>
            @endif

            <form action="{{ route('comments.store', $article) }}" method="POST" style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                @csrf
                <textarea name="content" rows="3" required placeholder="Ваш комментарий..."
                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;"></textarea>
                @error('content') <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span> @enderror
                <button type="submit" style="margin-top: 10px; padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Отправить
                </button>
            </form>
        @endauth

        {{-- 💬 Список одобренных комментариев --}}
        <h3 style="margin: 30px 0 15px;">
            💬 Комментарии ({{ $article->approvedComments()->count() }})
        </h3>

        @forelse($article->approvedComments()->with('user')->latest()->get() as $comment)
            <div style="padding: 12px 15px; margin-bottom: 10px; background: #f8f9fa; border-radius: 6px; border-left: 3px solid #3498db;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <strong style="color: #2c3e50;">{{ $comment->user->name }}</strong>
                    <small style="color: #777;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </div>
                <p style="margin: 0; color: #555;">{{ $comment->content }}</p>
            </div>
        @empty
            <p style="color: #777; font-style: italic;">Комментариев пока нет. Будьте первым!</p>
        @endforelse
    </div>
@endsection

