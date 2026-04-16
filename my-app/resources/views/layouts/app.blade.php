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
    </style>
</head>

<body>
    <header>
        <nav>
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('about') }}">О нас</a>
            <a href="{{ route('contacts') }}">Контакты</a>
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