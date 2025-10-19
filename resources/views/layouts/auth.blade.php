<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
        .auth-bg {
            background-image: url('{{ env('ADMIN_BG_URL', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1600&auto=format&fit=crop&ixlib=rb-4.0.3&s=1f1b9b6b8a6f0f7d3c6c9b2b6b7e6a2f') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
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
