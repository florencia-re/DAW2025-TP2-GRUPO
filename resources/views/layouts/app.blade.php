<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fuente opcional --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Bootstrap 5 CSS desde CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Archivos de Vite (Tailwind y JS de Laravel) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark text-light">
    <div class="min-vh-100 d-flex flex-column">

        {{-- Barra de navegación (de Breeze o personalizada) --}}
        @include('layouts.navigation')

        {{-- Cabecera opcional --}}
        @isset($header)
            <header class="bg-secondary text-white py-3 shadow-sm">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenido principal --}}
        <main class="flex-grow-1 py-4">
            <div class="container">
                {{ $slot ?? '' }}
                @yield('content') {{-- para vistas extendidas --}}
            </div>
        </main>

        {{-- Pie de página opcional --}}
        <footer class="bg-dark text-center py-3 border-top border-secondary">
            <small>© {{ date('Y') }} Proyecto DAW2025 - Grupo Charls</small>
        </footer>
    </div>

    {{-- Bootstrap JS (desde CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
