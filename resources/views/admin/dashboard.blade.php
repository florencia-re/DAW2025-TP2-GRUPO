{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    {{-- Slot del encabezado --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal del contenido --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tarjeta principal del panel --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Mensaje de bienvenida dinámico con el nombre del usuario autenticado --}}
                    <h3 class="text-lg font-semibold mb-4">
                        Bienvenido, {{ Auth::user()->name }} 👋
                    </h3>

                    {{-- Descripción general del panel --}}
                    <p class="mb-6">
                        Este es tu panel de administración. Desde aquí podrás acceder a las secciones principales del sistema.
                    </p>

                    {{-- Sección de accesos rápidos tipo “cards” --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Card: Usuarios --}}
                        <a href="{{ route('users.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="text-lg font-semibold mb-2">👥 Gestión de Usuarios</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Ver, editar o eliminar usuarios registrados en el sistema.</p>
                        </a>

                        {{-- Card: Perfil --}}
                        <a href="{{ route('profile.edit') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="text-lg font-semibold mb-2">⚙️ Perfil</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Actualizá tus datos personales y credenciales.</p>
                        </a>

                        {{-- Card: Dashboard general --}}
                        <a href="{{ route('dashboard') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="text-lg font-semibold mb-2">📊 Volver al Panel Principal</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Ir al panel general del sistema.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- 
Resumen:
Este archivo muestra un panel administrativo para usuarios autenticados.
Incluye tres accesos rápidos (Usuarios, Perfil, Dashboard principal).
El diseño usa Tailwind (propio de Laravel Breeze) con soporte para modo oscuro.
--}}

