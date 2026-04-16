@extends('layouts.app')

@section('title', 'Создание новости')

@section('content')
    <h1>Добавить новость</h1>

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Заголовок *</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">
            @error('name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Дата публикации *</label>
            <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">
            @error('published_at') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Краткое описание</label>
            <textarea name="short_desc" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc;">{{ old('short_desc') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Полный текст *</label>
            <textarea name="full_text" rows="6" required style="width: 100%; padding: 8px; border: 1px solid #ccc;">{{ old('full_text') }}</textarea>
            @error('full_text') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Превью (картинка)</label>
            <input type="file" name="preview_image" style="display: block; margin-bottom: 5px;">
            @error('preview_image') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Полная картинка</label>
            <input type="file" name="full_image" style="display: block; margin-bottom: 5px;">
        </div>

        <button type="submit" style="background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Сохранить</button>
        <a href="{{ route('articles.index') }}" style="margin-left: 10px; color: #555;">Отмена</a>
    </form>
@endsection
