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
                    <form method="POST" action="/stamp/home" >
                        @csrf
                        <a href="/stamp/home">ホーム</a>
                    </form>
                </li>
                <li class="header-li">
                    <form method="POST" action="/stamp/list" >
                        @csrf
                        <a href="/stamp/list">日付一覧</a>
                    </form>
                </li>
                <li class="header-li">
                    <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('ログアウト') }}
                    </x-responsive-nav-link>
                </form>
                </li>
            </ul>
        </header>
        <main>


            
        </main>
        <footer>
        <p class="footer-logo">Atte,inc.</p>
        </footer>
    </body>
</html>
