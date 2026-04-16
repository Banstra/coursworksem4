@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div style="max-width: 500px; margin: 0 auto;">
        <h1 style="color: #2c3e50; margin-bottom: 20px;">Регистрация</h1>

        {{-- Форма с POST-методом и CSRF-токеном --}}
        <form action="{{ route('signin.store') }}" method="POST" id="registrationForm">
            @csrf {{-- 🔐 Обязательный CSRF-токен Laravel --}}

            {{-- Имя --}}
            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; margin-bottom: 5px; font-weight: 500;">Имя *</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       required
                       minlength="2"
                       maxlength="50"
                       placeholder="Введите ваше имя"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                @error('name')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email *</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email') }}"
                       required
                       maxlength="100"
                       placeholder="example@mail.com"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                @error('email')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Пароль --}}
            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; margin-bottom: 5px; font-weight: 500;">Пароль *</label>
                <input type="password"
                       name="password"
                       id="password"
                       required
                       minlength="8"
                       placeholder="Минимум 8 символов"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                @error('password')
                <span style="color: #e74c3c; font-size: 14px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Подтверждение пароля --}}
            <div style="margin-bottom: 20px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 500;">Подтвердите пароль *</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       required
                       minlength="8"
                       placeholder="Повторите пароль"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>

            {{-- Кнопка отправки --}}
            <button type="submit"
                    style="width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: 500;">
                Зарегистрироваться
            </button>
        </form>

        {{-- Блок для вывода ответа (AJAX) --}}
        <div id="responseMessage" style="margin-top: 20px; padding: 15px; border-radius: 4px; display: none;"></div>
    </div>

    {{-- 📜 Скрипт для отправки формы через Fetch API (чтобы получить JSON без перезагрузки) --}}
    <script>
        document.getElementById('registrationForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const responseDiv = document.getElementById('responseMessage');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    responseDiv.style.background = '#d4edda';
                    responseDiv.style.color = '#155724';
                    responseDiv.innerHTML = `<strong>✅ Успех!</strong><br>${result.message}<br>
                <small>Имя: ${result.data.name}<br>Email: ${result.data.email}</small>`;
                    form.reset();
                } else {
                    responseDiv.style.background = '#f8d7da';
                    responseDiv.style.color = '#721c24';
                    responseDiv.innerHTML = `<strong>❌ Ошибка:</strong><br>${result.message || 'Проверьте данные формы'}`;
                }
            } catch (error) {
                responseDiv.style.background = '#f8d7da';
                responseDiv.style.color = '#721c24';
                responseDiv.innerHTML = `<strong>❌ Ошибка сети:</strong><br>${error.message}`;
            }

            responseDiv.style.display = 'block';
        });
    </script>
@endsection
