<x-app-layout>
    <div>
        <img
            src="{{ $user->icon_image ? asset('storage/icons/' . $user->icon_image) : asset('images/default_icon.png') }}"
            alt="プロフィール画像"
            class="mt-2 w-24 h-24 object-cover rounded-full">
    </div>
    <div class="mt-4">
        <div>
            名前: {{ $user->name }}
        </div>
        <div class="mt-4">
            @if($user->bio)
                自己紹介: {{ $user->bio }}
            @endif
        </div>
    </div>
    <div class="mt-4">
        <x-primary-button href="{{ route('profile.edit') }}">
            プロフィール編集
        </x-primary-button>
    </div>
</x-app-layout>