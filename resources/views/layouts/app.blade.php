<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- アイコンの読み込み -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        
        <title>{{ $title ?? 'Travel Planner' }}</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
    <!-- ヘッダー -->
    <header>
        @auth
            @include('layouts.navigation')
        @else
            @include('components.guest-header')
        @endauth
    </header>

    <!-- Breeze の slot -->
    <div class="min-h-screen flex flex-col p-6 bg-cream text-primary01">
        @isset($title)
            <div class="font-bold text-2xl pb-2">
                {{ $title }}
            </div>
        @endisset
        <div class="w-full max-w-7xl sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-primary01 text-primary02 p-6 text-center w-full">
        <p>© 2026 Travel Planner</p>
    </footer>
    </body>
</html>
