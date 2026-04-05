<x-app-layout>
    <div>
        @if($user->icom_image)
            <img src="{{ asset('' . $user->icon_image) }}">
        @endif
    </div>
    <div>
        <div>
            名前: {{ $user->name }}
        </div>
        <div>
            @if($user->bio)
                自己紹介: {{ $user->bio }}
            @endif
        </div>
        <div>
            メール: {{ $user->email }}（非公開）
        </div>
    </div>
    <div>
        <x-primary-button href="{{ route('profile.edit') }}">
            プロフィール編集
        </x-primary-button>
    </div>
</x-app-layout>