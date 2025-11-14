@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 border-b pb-3">
            {{-- Título principal --}}
            <h2 class="text-3xl font-bold text-gray-800">Clientes</h2>
            <div class="flex space-x-3">
                {{-- Botón para Crear Cliente --}}
                <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                    + Nuevo Cliente
                </a>
            </div>
        </div>

        {{-- Mensajes flash (éxito/error) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alta</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($clients as $c)
                    <tr class="hover:bg-gray-50">
                        {{-- Datos del Cliente (usando $c) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $c->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $c->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $c->cuit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c->created_at->format('d/m/Y') }}</td>

                        {{-- Acciones (Botones - TODAS USAN $c) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">

                             {{-- Botón para Editar --}}
                            <a href="{{ route('clients.edit', $c->id) }}" class="text-yellow-600 hover:text-yellow-900 font-semibold text-xs">Editar</a>

                            {{-- Botón para Ver Ventas --}}
                            <a href="{{ route('sales.listSalesByCuit', $c->cuit) }}" class="text-purple-600 hover:text-purple-900 font-semibold text-xs">
                                Ventas
                            </a>

                            {{-- Botón para Eliminar (Soft Delete - variable $c) --}}
                            <form action="{{ route('clients.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea enviar a la papelera a {{ $c->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">No hay clientes registrados.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="p-4 bg-white border-t border-gray-200">
                {{ $clients->links() }}
            </div>

        </div>
    </div>
@endsection
