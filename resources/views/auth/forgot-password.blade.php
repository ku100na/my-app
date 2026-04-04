<x-guest-layout>
    <x-card>
        <div class="font-bold text-xl pb-2">
                パスワードリセット
        </div>

        <div class="p-6">
            <div class="mb-4 text-sm text-gray-600">
                登録したメールアドレスを入力してください。<br>
                リセット用のリンクを送信します。
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="メールアドレス" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button type="submit">
                        送信
                    </x-primary-button>
                </div>

                <div class="mt-4">
                    <a class="underline hover:text-indigo-500"
                                href="{{ route('login') }}">
                                    ログインに戻る
                                </a>
                </div>
            </form>
        </div>
    </x-card>
</x-guest-layout>
