@yield('header')
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
