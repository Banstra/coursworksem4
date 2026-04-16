@extends('layouts.app')

@section('title', 'Доступ запрещён')

@section('content')
    <div style="max-width: 500px; margin: 50px auto; text-align: center; padding: 30px; background: #fff; border-radius: 8px; border: 1px solid #e74c3c;">
        <h1 style="color: #e74c3c;">⛔ 403 — Доступ запрещён</h1>
        <p style="color: #555; margin: 20px 0;">
            {{ $exception->getMessage() ?: 'У вас недостаточно прав для выполнения этого действия.' }}
        </p>
        <a href="{{ route('home') }}" style="display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 4px;">
            На главную
        </a>
    </div>
@endsection
