<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <div class="min-h-screen flex flex-col items-center p-6 bg-cream text-primary01">
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
