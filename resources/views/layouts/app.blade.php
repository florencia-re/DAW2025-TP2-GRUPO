<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name', 'DAW2025 TP2') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
  @include('layouts.navigation')

  <main class="container mx-auto p-4">
    @include('layouts.flash')
    @yield('content')
  </main>

  <footer class="text-center text-xs text-gray-500 p-6">
    © {{ date('Y') }} — TP2 Grupo N
  </footer>
</body>
</html>