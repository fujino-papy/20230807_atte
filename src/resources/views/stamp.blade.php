<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
        <title>Laravel</title>
    </head>
    <body class="antialiased">
        <header>
            <p class="title">Atte</p>
            <ul class="header-nav">
                <li class="header-li">
                    <a href="">ホーム</a>
                </li>
                <li class="header-li">
                    <a href="">日付一覧</a>
                </li>
                <li class="header-li">
                    <a href="">ログアウト</a>
                </li>
            </ul>

            <div class="header-nav">
            @if (Route::has('login'))
                <div class="header-li">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>
        <main>
                <h1 class="username">{{ Auth::user()->name }}さんお疲れ様です！</h1>
            </div>
            <form class="stamp">
                @csrf
                <button class="start" action="/stamp/start" method="post" type="submit">勤務開始</button>
                <button class="end" action="/stamp/end" method="post"type="submit">勤務終了</button>
            <br>
                <button class="rest-start" type="submit">休憩開始</button>
                <button class="rest-end" type="submit">休憩終了</button>
        </main>
        <footer>
        <p class="footer-logo">Atte,inc.</p>
        </footer>
    </body>
</html>
