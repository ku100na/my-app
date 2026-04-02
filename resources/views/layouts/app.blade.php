<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Travel Planner' }}</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream">
        <!-- Header -->
        <header class="bg-blue">
            <div class="container">
                <h1 class="text-xl font-bold">Travel Planner</h1>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="container">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-blue mx-auto">
            <div>© 2026 Travel Planner</div>
        </footer>
    </body>
</html>
