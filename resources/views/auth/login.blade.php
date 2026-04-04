<x-guest-layout>
    <x-card>
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="font-bold text-xl pb-2">
                ログイン
            </div>

            <div class="p-6">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="メールアドレス" />
                    <x-text-input id="email" class="block mt-1 w-full" 
                                    type="email" 
                                    name="email" :value="old('email')" 
                                    required autofocus autocomplete="username" />
                    
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" value="パスワード" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- ログインボタン -->
                <div class="mt-4 text-start">
                    <x-primary-button type="submit">
                        ログイン
                    </x-primary-button>
                </div>

                <!--パスワード忘れリンク -->
                <div class="mt-4">
                    @if (Route::has('password.request'))
                            <a class="underline hover:text-indigo-500"
                            href="{{ route('password.request') }}">
                                パスワードを忘れた方はこちら
                            </a>
                    @endif
                </div>

                <!--パスワード忘れリンク -->
                <div class="mt-4">  
                    アカウントをお持ちでない方→
                    <x-white-button href="{{ route('register') }}">
                        新規登録
                    </x-white-button>
                </div>
            </div>
        </form>
    </x-card>
</x-guest-layout>
