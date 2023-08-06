<x-guest-layout>
    <x-auth-card>
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{asset('css/register.css')}}"/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>会員登録</h1>
            <!-- Name -->
            <div　class="name">
                <input id="name" class="name" type="text" name="name" :value="old('name')" placeholder="名前" required autofocus />
            </div>

            <!-- Email Address -->
            <div>
                <input id="email" class="mail" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
            </div>

            <!-- Password -->
            <div>
                <input id="password" class="pass"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="パスワード" />
            </div>

            <!-- Confirm Password -->
            <div>
                <input id="password_confirmation" class="pass-confirmation"
                                type="password"
                                name="password_confirmation"　
                                placeholder="確認用パスワード" required />
            </div>

                <x-button class="register_button">
                    {{ __('会員登録') }}
                </x-button>

            <p class="guidance">アカウントをお持ちの方はこちらから</p>
            <div class="flex items-center justify-center">
            @if (Route::has('login'))
                <a class="login" href="{{ route('login') }}">
                    {{ __('ログイン') }}
                </a>
            @endif
        </div>
        </form>
    </x-auth-card>
</x-guest-layout>
