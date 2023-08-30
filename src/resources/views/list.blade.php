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
            <div class="list-table">
            <table class="list-table_inner" style="width: 100%; max-width: 0 auto;">
            <tr class="list-table_info">
                <th scope ="col">名前</th>
                <th scope ="col">勤務開始</th>
                <th scope ="col">勤務終了</th>
                <th scope ="col">休憩時間</th>
                <th scope ="col">勤務時間</th>
            </tr>
            @foreach($attendanceWithWorktime as $entry)
            <tr class="list-table_data">
                <td>{{$entry->user_id}}</td>
                <td>{{$entry->start_work}}</td>
                <td>{{$entry->end_work}}</td>
                <td>{{$entry->resttime}}</td>
                <td>{{$entry->worktime}}</td>
            </tr>
            @endforeach
            </table>
            </div>

        
        </main>
        <footer>
        <p class="footer-logo">Atte,inc.</p>
        </footer>
    </body>
</html>
