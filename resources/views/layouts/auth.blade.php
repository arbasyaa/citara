<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/css/auth.css','resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen auth-bg relative">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        @yield('auth.content')
    </div>
    @stack('scripts')
</body>
</html>
