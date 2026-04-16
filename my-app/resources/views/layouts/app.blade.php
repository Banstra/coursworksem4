<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Курсовая работа')</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            background: #f5f7fa;
            color: #333;
        }

        header {
            background: #2c3e50;
            padding: 1rem 0;
        }

        nav {
            max-width: 900px;
            margin: 0 auto;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-weight: 500;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            min-height: 50vh;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            background: #2c3e50;
            color: #ecf0f1;
            margin-top: 3rem;
        }

         .pagination {
             display: flex;
             gap: 4px;
             list-style: none;
             padding: 0;
             margin: 20px 0 0;
             flex-wrap: wrap;
             justify-content: center;
         }
        .page-item {
            display: inline-block;
        }
        .page-link {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            background: #fff;
        }
        .page-link:hover,
        .page-link:focus {
            background: #3498db;
            color: #fff;
            border-color: #3498db;
            outline: none;
        }
        .page-item.active .page-link {
            background: #2c3e50;
            color: #fff;
            border-color: #2c3e50;
            font-weight: 600;
            cursor: default;
        }
        .page-item.disabled .page-link {
            color: #aaa;
            pointer-events: none;
            background: #f5f5f5;
        }

    </style>
</head>

<body>
    <header>
        <!-- В <nav> добавьте: -->
        <nav>
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('articles.index') }}">Новости</a>

            @auth
                <a href="{{ route('profile') }}">Профиль</a>
                <a href="{{ route('articles.create') }}">+ Статья</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font: inherit; text-decoration: underline;">
                        Выход ({{ Auth::user()->name }})
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Вход</a>
                <a href="{{ route('register') }}">Регистрация</a>
            @endauth
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>ФИО: Иванов Иван Иванович | Группа: ИТ-301</p>
    </footer>
</body>

</html>
