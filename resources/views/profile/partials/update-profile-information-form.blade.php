<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            プロフィール情報
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" novalidate>
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="名前" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        あなたのメールアドレスは未認証です。

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-indigo-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            認証メールを送信
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            認証メールが送信されました。
                        </p>
                    @endif
                </div>
            @endif
            
            @if (session('status') === 'verified')
                <p class="mt-2 font-medium text-sm text-green-600">
                    メールが認証されました。
                </p>
            @endif
        </div>

        <div>
            <x-input-label for="icon_image" value="プロフィール画像" />
            <x-text-input id="icon_image" name="icon_image" type="file" class="mt-1 block w-full"/>
            <img id="icon_preview" src="{{ $user->icon_image ? asset('storage/icons/' . $user->icon_image) : asset('images/default_icon.png') }}" alt="プレビュー" class="mt-2 w-24 h-24 object-cover rounded-full">
            
            <x-input-error class="mt-2" :messages="$errors->get('icon_image')" />
        </div>

        <script>
            document.getElementById('icon_image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('icon_preview');

                if(file) {
                    preview.src = URL.createObjectURL(file);
                } else {
                    preview.src = "{{ $user->icon_image ? asset('storage/icons/' . $user->icon_image) : asset('images/default_icon.png') }}";
                }
            });
        </script>

        <div>
            <x-input-label for="bio" value="自己紹介" />
            <x-textarea id="bio" name="bio" rows="4" class="mt-1 block w-full" >{{ old('bio', $user->bio) }}</x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="submit">保存</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    class="text-sm text-gray-800"
                >保存されました</p>
            @endif
        </div>
    </form>
</section>
