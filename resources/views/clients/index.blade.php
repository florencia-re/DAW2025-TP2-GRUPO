@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Clientes</h1>
        <a href="{{ route('clients.create') }}" class="text-blue-600 underline">Nuevo Cliente</a>
    </div>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Nombre</th>
                <th class="p-2">Email</th>
                <th class="p-2">Teléfono</th>
                <th class="p-2">Fecha alta</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $c)
                <tr class="border-t">
                    <td class="p-2">{{ $c->id }}</td>
                    <td class="p-2">{{ $c->name }}</td>
                    <td class="p-2">{{ $c->email }}</td>
                    <td class="p-2">{{ $c->phone }}</td>
                    <td class="p-2">{{ $c->created_at->format('d/m/Y') }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('clients.edit', $c) }}" class="text-blue-600 underline">Editar</a>

                        <a href="{{ route('clients.sales.show', $c) }}" class="text-purple-600 underline">
                            Ver Ventas
                        </a>

                        <form action="{{ route('clients.destroy', $c) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar cliente?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 underline">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-3 text-center" colspan="6">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>
@endsection