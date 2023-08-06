<x-guest-layout>
    <x-auth-card>
            <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
            <link rel="stylesheet" href="{{asset('css/login.css')}}"/>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input id="email" class="mail" type="email" name="email"  required autofocus placeholder="メールアドレス" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input id="password" class="pass"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="パスワード" />
            </div>
            <x-button class="login_button">
                {{ __('ログイン') }}
            </x-button>

            <p class="guidance">アカウントをお持ちでない方はこちらから</p>
            <div class="register">
                @if (Route::has('register'))
                    <a class="register" href="{{ route('register') }}">
                        {{ __('会員登録') }}
                    </a>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
