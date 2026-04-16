@extends('layouts.app')

@section('title', 'Редактирование: ' . $article->name)

@section('content')
    <h1>Редактировать: {{ $article->name }}</h1>

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Заголовок *</label>
            <input type="text" name="name" value="{{ old('name', $article->name) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">
            @error('name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Дата публикации *</label>
            <input type="date" name="published_at" value="{{ old('published_at', $article->published_at->format('Y-m-d')) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Полный текст *</label>
            <textarea name="full_text" rows="6" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">{{ old('full_text', $article->full_text) }}</textarea>
            @error('full_text') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Загрузить новое превью</label>
            <input type="file" name="preview_image">
        </div>

        <!-- Вставьте этот блок после поля "Полный текст" и перед "Загрузить новое превью" -->
        <div style="margin-bottom: 15px;">
            <label>Текущее превью:</label><br>
            @if($article->preview_image)
                <img src="{{ asset('images/' . $article->preview_image) }}"
                     alt="Текущее превью"
                     style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 10px;">
                <br>
                <small style="color: #777;">{{ $article->preview_image }}</small>
            @else
                <span style="color: #999; font-style: italic;">Нет изображения</span>
            @endif
        </div>

        <div style="margin-bottom: 15px;">
            <label>Загрузить новое превью (опционально)</label>
            <input type="file" name="preview_image" style="display: block; margin-top: 5px;">
            @error('preview_image') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" style="background: #f39c12; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Обновить</button>
        <a href="{{ route('articles.index') }}" style="margin-left: 10px; color: #555;">Отмена</a>
    </form>
@endsection
