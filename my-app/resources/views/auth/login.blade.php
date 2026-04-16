@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div style="max-width: 450px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">🔑 Вход</h2>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                @error('email') <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; margin-bottom: 5px; font-weight: 500;">Пароль *</label>
                <input type="password" name="password" id="password" required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                @error('password') <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: 500;">
                Войти
            </button>
        </form>

        <p style="text-align: center; margin-top: 15px; color: #777;">
            Нет аккаунта? <a href="{{ route('register') }}" style="color: #3498db; text-decoration: none;">Зарегистрироваться</a>
        </p>
    </div>
@endsection
